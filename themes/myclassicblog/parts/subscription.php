<div class="row s-footer__subscribe">
   <div class="column lg-12">

      <h2>
         Subscribe to Our Newsletter.
      </h2>
      <p>
         Subscribe now to get all latest updates
      </p>

      <form id="mc-form" class="mc-form" method="post">
         <?php wp_nonce_field('subscribe_action', 'subscribe_nonce'); ?>
         <input type="email" name="subscriber_email" id="subscriber_email" class="u-fullwidth text-center"
            placeholder="Your Email Address"
            title="Subscribe"
            required
            value="<?php echo isset($_POST['subscriber_email']) ? esc_attr($_POST['subscriber_email']) : ''; ?>">
         <input type="submit" name="subscribe" value="Subscribe"
            class="btn--small btn--primary u-fullwidth">
         <div class="mc-status">
            <?php
            // Display success/error messages
            if (isset($_GET['subscription'])) {
               if ($_GET['subscription'] == 'success') {
                  echo '<p class="success-message">Thank you for subscribing!</p>';
               } elseif ($_GET['subscription'] == 'error') {
                  echo '<p class="error-message">An error occurred. Please try again.</p>';
               } elseif ($_GET['subscription'] == 'duplicate') {
                  echo '<p class="info-message">This email is already subscribed.</p>';
               } elseif ($_GET['subscription'] == 'invalid') {
                  echo '<p class="error-message">Please enter a valid email address.</p>';
               }
            }
            ?>
         </div>
      </form>
      <p class="privacy-note" style="font-size: 12px; color: #666; margin-top: 10px;">
         We respect your privacy. Unsubscribe at any time.
      </p>
   </div>
</div>