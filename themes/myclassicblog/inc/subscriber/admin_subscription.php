<?php

// Add admin menu for subscribers
function add_subscribers_admin_page()
{
   add_menu_page(
      'Blog Subscribers',
      'Subscribers',
      'manage_options',
      'blog-subscribers',
      'my_subscribers_content',
      'dashicons-email-alt',
      30
   );
}
add_action('admin_menu', 'add_subscribers_admin_page');

function my_subscribers_content()
{
   global $wpdb;
   $table_name = $wpdb->prefix . 'blog_subscriber';

   // Handle export
   if (isset($_GET['export']) && $_GET['export'] == 'csv') {
      $subscribers = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");

      header('Content-Type: text/csv');
      header('Content-Disposition: attachment; filename="subscribers-' . date('Y-m-d') . '.csv"');

      $output = fopen('php://output', 'w');
      fputcsv($output, array('ID', 'Email', 'Subscribed Date', 'Last Email Sent', 'Total Emails Sent', 'Status'));

      foreach ($subscribers as $subscriber) {
         fputcsv($output, array(
            $subscriber->id,
            $subscriber->email,
            $subscriber->created_at,
            $subscriber->status
         ));
      }
      fclose($output);
      exit;
   }

   // Get subscribers
   $subscribers = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");
   $total = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'active'");
?>
   <div class="wrap">
      <h1>Blog Subscribers</h1>
      <p>Total active subscribers: <strong><?php echo $total; ?></strong></p>
      <a href="<?php echo admin_url('admin.php?page=blog-subscribers&export=csv'); ?>" class="button button-primary">Export as CSV</a>

      <table class="wp-list-table widefat fixed striped" style="margin-top: 20px;">
         <thead>
            <tr>
               <th>ID</th>
               <th>Email</th>
               <th>Subscribed Date</th>
               <th>Status</th>
            </tr>
         </thead>
         <tbody>
            <?php if ($subscribers): ?>
               <?php foreach ($subscribers as $subscriber): ?>
                  <tr>
                     <td><?php echo $subscriber->id; ?></td>
                     <td><?php echo esc_html($subscriber->email); ?></td>
                     <td><?php echo date('F j, Y g:i a', strtotime($subscriber->created_at)); ?></td>
                     <td><?php echo ucfirst($subscriber->status); ?></td>
                  </tr>
               <?php endforeach; ?>
            <?php else: ?>
               <tr>
                  <td colspan="6">No subscribers found.</td>
               </tr>
            <?php endif; ?>
         </tbody>
      </table>
   </div>
<?php
}
