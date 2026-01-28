<?php

// Defining constants
define('SITE_VERSION', wp_get_theme()->get('Version'));

// Theme setups
add_action('after_setup_theme', 'ya_myclassicblog_setup');
function ya_myclassicblog_setup()
{
   add_theme_support('title-tag');
   add_theme_support('post-thumbnails');
   // add_theme_support('custom-logo');
   remove_theme_support('custom-logo');
   add_theme_support('html5', array('search-form', 'comment-list', 'comment-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets'));
   add_theme_support('responsive-embeds');
   add_theme_support('align-wide');
   add_theme_support('wp-block-styles');
   add_theme_support('editor-styles');
   add_editor_style('editor-style.css');
   add_theme_support('appearance-tools');
   add_theme_support('woocommerce');
   global $content_width;
   if (!isset($content_width)) {
      $content_width = 1920;
   }
   register_nav_menus(array('header_menu' => esc_html__('Main Menu', 'ya_myclassicblog')));
   register_nav_menus(array('footer_menu_1' => esc_html__('Footer Menu 1', 'ya_myclassicblog')));
   register_nav_menus(array('footer_menu_2' => esc_html__('Footer Menu 2', 'ya_myclassicblog')));

   // Custom Thumbnail size
   add_image_size('blog-thumb', 370, 480, false);
   add_image_size('hero-thumb', 760, 815, false);
}

// Adding header meta tag codes
add_action('wp_head', 'add_head_meta_codes');
function add_head_meta_codes()
{
?>
   <meta charset="<?php bloginfo('charset'); ?>">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <script>
      document.documentElement.classList.remove('no-js');
      document.documentElement.classList.add('js');
   </script>
   <link rel="manifest" href="site.webmanifest">
<?php
}

// Adding header and footer CSS and JS
add_action('wp_enqueue_scripts', 'ya_header_footer_codes');
function ya_header_footer_codes()
{
   // Header Codes
   wp_enqueue_style('ya_myclassicblog-style', get_stylesheet_uri());
   wp_enqueue_script('jquery');
   wp_enqueue_style('ya_vendor_css', get_template_directory_uri() . '/assets/css/vendor.css', array(), SITE_VERSION);
   wp_enqueue_style('ya_site_style_css', get_template_directory_uri() . '/assets/css/styles.css', array(), SITE_VERSION);

   // Footer codes
   wp_enqueue_script('ya_plugins', get_template_directory_uri() . '/assets/js/plugins.js', array(), SITE_VERSION, true);
   wp_enqueue_script('ya_main', get_template_directory_uri() . '/assets/js/main.js', array(), SITE_VERSION, true);

   wp_enqueue_script('subscription-ajax', get_template_directory_uri() . '/assets/js/subscription.js', array('jquery'), '1.0', true);
   wp_localize_script('subscription-ajax', 'subscription_ajax', array(
      'ajax_url' => admin_url('admin-ajax.php'),
      'nonce' => wp_create_nonce('subscribe_ajax_nonce')
   ));
}

function my_dynamic_contact_form()
{
   if (isset($_POST['submit'])) {

      // Check nonce
      if (!isset($_POST['contact_form_nonce']) || !wp_verify_nonce($_POST['contact_form_nonce'], 'contact_form_submit')) {
         echo '<p style="color:red;">Security check failed. Please try again.</p>';
         return;
      }

      // Sanitize form inputs
      $name    = sanitize_text_field($_POST['cName']);
      $email   = sanitize_email($_POST['cEmail']);
      $website = esc_url_raw($_POST['cWebsite']);
      $message = sanitize_textarea_field($_POST['cMessage']);

      // Optional: send email
      $to      = get_option('admin_email'); // sends to site admin
      $subject = "New Contact Form Submission from $name";
      $headers = "From: $name <$email>\r\nReply-To: $email";
      $body    = "Name: $name\nEmail: $email\nWebsite: $website\nMessage:\n$message";

      wp_mail($to, $subject, $body, $headers);

      echo '<p style="color:green;">Thank you! Your message has been sent.</p>';
   }
}
add_action('wp_head', 'my_dynamic_contact_form'); // runs before page loads
