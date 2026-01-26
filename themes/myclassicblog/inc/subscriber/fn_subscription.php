<?php

// Create subscription table on theme activation
function create_subscription_table()
{
   global $wpdb;
   $table_name = $wpdb->prefix . 'blog_subscriber';
   $charset_collate = $wpdb->get_charset_collate();

   // Check if table already exists
   if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
      $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        email varchar(100) NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        status varchar(20) DEFAULT 'active',
        UNIQUE KEY email (email),
        PRIMARY KEY (id),
        KEY status_idx (status)
        ) $charset_collate;";

      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
      dbDelta($sql);
   }
}
add_action('after_setup_theme', 'create_subscription_table');

// Create table on theme activation
function theme_activation_setup()
{
   create_subscription_table();
}
add_action('after_switch_theme', 'theme_activation_setup');

// Handle subscription form submission
function handle_subscription_form()
{
   if (isset($_POST['subscribe']) && isset($_POST['subscriber_email'])) {

      // Verify nonce
      if (!wp_verify_nonce($_POST['subscribe_nonce'], 'subscribe_action')) {
         wp_die('Security check failed');
      }

      global $wpdb;
      $table_name = $wpdb->prefix . 'blog_subscriber';
      $email = sanitize_email($_POST['subscriber_email']);

      // Validate email
      if (!is_email($email)) {
         wp_redirect(add_query_arg('subscription', 'invalid', wp_get_referer()));
         exit;
      }

      // Check if email already exists
      $row = $wpdb->get_row($wpdb->prepare(
         "SELECT id, status FROM $table_name WHERE email = %s",
         $email
      ));

      if ($row) {
         if ($row->status === 'active') {
            wp_redirect(add_query_arg('subscription', 'duplicate', wp_get_referer()));
            exit;
         } else {
            // Re-subscribe user
            $wpdb->update(
               $table_name,
               array('status' => 'active'),
               array('id' => $row->id),
               array('%s'),
               array('%d')
            );

            wp_redirect(add_query_arg('subscription', 'success', wp_get_referer()));
            exit;
         }
      }

      // Insert new subscriber
      $result = $wpdb->insert(
         $table_name,
         array(
            'email' => $email,
            'created_at' => current_time('mysql'),
            'status' => 'active'
         ),
         array('%s', '%s', '%s')
      );
   }
}
add_action('template_redirect', 'handle_subscription_form');

// AJAX subscription handler
function ajax_handle_subscription()
{
   check_ajax_referer('subscribe_ajax_nonce', 'security');

   global $wpdb;
   $table_name = $wpdb->prefix . 'blog_subscriber';
   $email = sanitize_email($_POST['email']);

   if (!is_email($email)) {
      wp_send_json_error('Please enter a valid email address.');
   }

   // Check if email exists
   $row = $wpdb->get_row($wpdb->prepare(
      "SELECT id, status FROM $table_name WHERE email = %s",
      $email
   ));

   if ($row) {
      if ($row->status === 'active') {
         wp_send_json_error('This email is already subscribed.');
      } else {
         // Re-subscribe user
         $wpdb->update(
            $table_name,
            array('status' => 'active'),
            array('id' => $row->id),
            array('%s'),
            array('%d')
         );

         wp_send_json_success('Welcome back! You have been re-subscribed.');
      }
   }

   // Insert new subscriber
   $result = $wpdb->insert(
      $table_name,
      array(
         'email' => $email,
         'created_at' => current_time('mysql'),
         'status' => 'active'
      ),
      array('%s', '%s', '%s')
   );

   if ($result) {
      wp_send_json_success('Thank you for subscribing!');
   } else {
      wp_send_json_error('An error occurred. Please try again.');
   }
}
add_action('wp_ajax_subscribe_email', 'ajax_handle_subscription');
add_action('wp_ajax_nopriv_subscribe_email', 'ajax_handle_subscription');

// Email template
require 'email_subscription.php';

// Create Subscriber page in wordpress sidebar.
require 'admin_subscription.php';
