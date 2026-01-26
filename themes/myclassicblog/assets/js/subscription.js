jQuery(document).ready(function ($) {
   $('#mc-form').on('submit', function (e) {
      e.preventDefault();

      var form = $(this);
      var email = $('#subscriber_email').val();
      var statusDiv = $('.mc-status');

      // Show loading state
      statusDiv.html('<p class="loading">Processing...</p>');

      $.ajax({
         url: subscription_ajax.ajax_url,
         type: 'POST',
         data: {
            action: 'subscribe_email',
            email: email,
            security: subscription_ajax.nonce
         },
         success: function (response) {
            if (response.success) {
               statusDiv.html('<p class="success">' + response.data + '</p>');
               form[0].reset();
            } else {
               statusDiv.html('<p class="error">' + response.data + '</p>');
            }
         },
         error: function () {
            statusDiv.html('<p class="error">An error occurred. Please try again.</p>');
         }
      });
   });
});