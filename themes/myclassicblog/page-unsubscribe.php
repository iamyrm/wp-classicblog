<?php

/**
 * Template Name: Unsubscribe Page
 */
get_header();
?>

<div class="s-footer s-footer__subscribe">
   <div class="row">
      <div class="column lg-12">

         <?php
         // Handle unsubscribe logic
         if (isset($_GET['email']) && !empty($_GET['email'])) {
            $email = sanitize_email($_GET['email']);

            if (is_email($email)) {
               global $wpdb;
               $table_name = $wpdb->prefix . 'blog_subscriber';

               $exists = $wpdb->get_var($wpdb->prepare(
                  "SELECT id FROM $table_name WHERE email = %s",
                  $email
               ));

               if ($exists) {
                  $wpdb->update(
                     $table_name,
                     array('status' => 'unsubscribed'),
                     array('email' => $email),
                     array('%s'),
                     array('%s')
                  );
         ?>
                  <h2>✓ Successfully Unsubscribed</h2>
                  <p>Your email <strong><?php echo esc_html($email); ?></strong> has been removed from our mailing list.</p>
                  <p class="info-message">You will no longer receive newsletter emails from us.</p>
                  <p style="margin-top: 30px;"><a href="<?php echo esc_url(home_url()); ?>" class="btn--small btn--primary">Return to Homepage</a></p>
               <?php
               } else {
               ?>
                  <h2>Email Not Found</h2>
                  <p class="error-message">The email address <strong><?php echo esc_html($email); ?></strong> was not found in our subscription list.</p>
                  <p>You may have already unsubscribed, or the email was never subscribed.</p>
                  <div style="margin-top: 30px;">
                     <p>Please enter your email address to try again:</p>
                     <form method="get" action="" class="mc-form" style="margin-top: 20px;">
                        <input type="email" name="email" class="u-fullwidth text-center"
                           placeholder="Your Email Address"
                           title="Enter your email"
                           required>
                        <input type="submit" value="Try Again"
                           class="btn--small btn--primary u-fullwidth"
                           style="margin-top: 10px;">
                     </form>
                  </div>
               <?php
               }
            } else {
               // Invalid email format
               ?>
               <h2>Invalid Email Address</h2>
               <p class="error-message">Please provide a valid email address.</p>
               <div style="margin-top: 30px;">
                  <p>Please enter your email address to unsubscribe:</p>
                  <form method="get" action="" class="mc-form" style="margin-top: 20px;">
                     <input type="email" name="email" class="u-fullwidth text-center"
                        placeholder="Your Email Address"
                        title="Enter your email"
                        required>
                     <input type="submit" value="Unsubscribe"
                        class="btn--small btn--primary u-fullwidth"
                        style="margin-top: 10px;">
                  </form>
               </div>
            <?php
            }
         } else {
            // No email provided - show unsubscribe form
            ?>
            <h2>
               Unsubscribe from Our Newsletter
            </h2>
            <p>
               Enter your email address below to unsubscribe from our newsletter.
            </p>

            <form method="get" action="" class="mc-form">
               <input type="email" name="email" class="u-fullwidth text-center"
                  placeholder="Your Email Address"
                  title="Enter your email to unsubscribe"
                  required
                  value="<?php echo isset($_GET['email']) ? esc_attr($_GET['email']) : ''; ?>">
               <input type="submit" value="Unsubscribe"
                  class="btn--small btn--primary u-fullwidth">
               <div class="mc-status">
                  <?php
                  // Show any status messages
                  if (isset($_GET['error'])) {
                     if ($_GET['error'] == 'invalid_email') {
                        echo '<p class="error-message">Please enter a valid email address.</p>';
                     }
                  }
                  ?>
               </div>
            </form>

            <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee;">
               <p><strong>Didn't mean to unsubscribe?</strong></p>
               <p>If you'd like to stay subscribed or have any questions, please <a href="<?php echo esc_url(home_url('/contact/')); ?>">contact us</a>.</p>
               <p style="margin-top: 15px;"><a href="<?php echo esc_url(home_url()); ?>">← Return to Homepage</a></p>
            </div>
         <?php
         }
         ?>

         <p class="privacy-note" style="font-size: 12px; color: #666; margin-top: 30px;">
            We respect your privacy. If you have any concerns about your data, please <a href="<?php echo esc_url(home_url('/privacy/')); ?>">review our privacy policy</a>.
         </p>
      </div>
   </div>
</div>

<?php get_footer(); ?>