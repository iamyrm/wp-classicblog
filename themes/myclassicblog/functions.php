<?php
add_action('after_setup_theme', 'ya_myclassicblog_setup');
function ya_myclassicblog_setup()
{
   add_theme_support('title-tag');
   add_theme_support('post-thumbnails');
   add_theme_support('custom-logo');
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
   // register_nav_menus(array('main-menu' => esc_html__('Main Menu', 'ya_myclassicblog')));
}

add_action('wp_enqueue_scripts', 'ya_myclassicblog_enqueue');
function ya_myclassicblog_enqueue()
{
   wp_enqueue_style('ya_myclassicblog-style', get_stylesheet_uri());
   wp_enqueue_script('jquery');
}

add_filter('the_title', 'ya_myclassicblog_title');
function ya_myclassicblog_title($title)
{
   if ($title == '') {
      return esc_html('...');
   } else {
      return wp_kses_post($title);
   }
}

function ya_myclassicblog_schema_type()
{
   $schema = 'https://schema.org/';
   if (is_single()) {
      $type = "Article";
   } elseif (is_author()) {
      $type = 'ProfilePage';
   } elseif (is_search()) {
      $type = 'SearchResultsPage';
   } else {
      $type = 'WebPage';
   }
   echo 'itemscope itemtype="' . esc_url($schema) . esc_attr($type) . '"';
}

add_filter('nav_menu_link_attributes', 'ya_myclassicblog_schema_url', 10);
function ya_myclassicblog_schema_url($atts)
{
   $atts['itemprop'] = 'url';
   return $atts;
}

if (!function_exists('ya_myclassicblog_wp_body_open')) {
   function ya_myclassicblog_wp_body_open()
   {
      do_action('wp_body_open');
   }
}

add_action('wp_head', 'ya_myclassicblog_pingback_header');
function ya_myclassicblog_pingback_header()
{
   if (is_singular() && pings_open()) {
      printf('<link rel="pingback" href="%s">' . "\n", esc_url(get_bloginfo('pingback_url')));
   }
}
add_action('comment_form_before', 'ya_myclassicblog_enqueue_comment_reply_script');
function ya_myclassicblog_enqueue_comment_reply_script()
{
   if (get_option('thread_comments')) {
      wp_enqueue_script('comment-reply');
   }
}
function ya_myclassicblog_custom_pings($comment)
{
?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?></li>
<?php
}
add_filter('get_comments_number', 'ya_myclassicblog_comment_count', 0);
function ya_myclassicblog_comment_count($count)
{
   if (!is_admin()) {
      global $id;
      $get_comments = get_comments('status=approve&post_id=' . $id);
      $comments_by_type = separate_comments($get_comments);
      return count($comments_by_type['comment']);
   } else {
      return $count;
   }
}
