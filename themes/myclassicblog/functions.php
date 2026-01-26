<?php
require 'inc/site_functions.php';
require 'inc/menu_navwalker.php';
require 'inc/customizer.php';
require 'inc/subscriber/fn_subscription.php';

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
