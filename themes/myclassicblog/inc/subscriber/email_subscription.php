<?php

// Process email batches
function process_email_batch($post_id)
{
   global $wpdb;
   $table_name = $wpdb->prefix . 'blog_subscriber';

   // Get post details
   $post = get_post($post_id);
   $post_title = get_the_title($post_id);
   $post_url = get_permalink($post_id);

   // Get excerpt or generate from content
   $excerpt = get_the_excerpt($post_id);
   if (empty($excerpt) || strlen($excerpt) < 20) {
      $content = strip_tags($post->post_content);
      $words = explode(' ', $content);
      $excerpt = implode(' ', array_slice($words, 0, 30));
      if (count($words) > 30) {
         $excerpt .= '...';
      }
   }

   // Get featured image
   $thumbnail = '';
   if (has_post_thumbnail($post_id)) {
      $thumbnail_url = get_the_post_thumbnail_url($post_id, 'medium');
      $thumbnail = $thumbnail_url ? '<img src="' . esc_url($thumbnail_url) . '" alt="' . esc_attr($post_title) . '" style="max-width: 100%; height: auto; margin: 15px 0;">' : '';
   }

   // Get current batch position
   $current_batch = get_post_meta($post_id, '_current_email_batch', true);
   $subscriber_ids = get_post_meta($post_id, '_subscriber_ids_to_email', true);
   $total_subscribers = get_post_meta($post_id, '_total_subscribers', true);

   if (empty($subscriber_ids)) {
      return;
   }

   // Calculate batch indices
   $batch_size = 5;
   $start_index = $current_batch * $batch_size;
   $batch_ids = array_slice($subscriber_ids, $start_index, $batch_size);

   // Prepare email content
   $site_name = get_bloginfo('name');
   $site_url = home_url();
   $subject = "New Post: " . $post_title;

   // Prepare base email template (without unsubscribe URL)
   $email_template = '<html><body>';
   $email_template .= '<h2>' . esc_html($post_title) . '</h2>';
   $email_template .= $thumbnail;
   $email_template .= '<p>' . esc_html($excerpt) . '</p>';
   $email_template .= '<p><a href="' . esc_url($post_url) . '" style="background-color: #0073aa; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">Read Full Post</a></p>';
   $email_template .= '<hr>';
   $email_template .= '<p><small>You received this email because you subscribed to ' . esc_html($site_name) . '.</small></p>';

   $headers = array(
      'Content-Type: text/html; charset=UTF-8',
      'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>'
   );

   // Send emails to this batch
   $sent_count = 0;
   foreach ($batch_ids as $subscriber_id) {
      $subscriber_email = $wpdb->get_var($wpdb->prepare(
         "SELECT email FROM $table_name WHERE id = %d AND status = %s",
         $subscriber_id,
         'active'
      ));

      if ($subscriber_email) {
         // Create personalized unsubscribe URL for each subscriber
         $unsubscribe_url = home_url('/unsubscribe/?email=' . urlencode($subscriber_email));

         // Complete the message with personalized unsubscribe link
         $message = $email_template;
         $message .= '<p><small><a href="' . esc_url($unsubscribe_url) . '">Click here to unsubscribe</a></small></p>';
         $message .= '</body></html>';

         
         $mail_sent = wp_mail($subscriber_email, $subject, $message, $headers);

         if ($mail_sent) {
            $sent_count++;
            // Update last_sent time
            $wpdb->update(
               $table_name,
               array('last_sent' => current_time('mysql')),
               array('id' => $subscriber_id),
               array('%s'),
               array('%d')
            );
         }
      }
   }

   // Update batch counter
   $next_batch = $current_batch + 1;
   update_post_meta($post_id, '_current_email_batch', $next_batch);

   // Calculate remaining
   $total_sent = ($next_batch * $batch_size);

   // Check if we have more batches to send
   if ($total_sent < $total_subscribers) {
      // Schedule next batch after 30 seconds
      wp_schedule_single_event(time() + 30, 'process_email_batch', array($post_id));

      // Log progress
      error_log("Email batch $next_batch sent for post $post_id. Sent $sent_count emails. Total sent: $total_sent / $total_subscribers");
   } else {
      // All emails sent
      update_post_meta($post_id, '_emails_sent_to_subscribers', 'yes');
      update_post_meta($post_id, '_email_sending_completed', current_time('mysql'));

      // Clean up
      delete_post_meta($post_id, '_subscriber_ids_to_email');
      delete_post_meta($post_id, '_current_email_batch');

      error_log("All emails sent for post $post_id. Total: $total_subscribers subscribers");
   }
}
