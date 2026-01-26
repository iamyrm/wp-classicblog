<?php

/**
 * Custom_Walker_Nav_Menu class
 *
 * Custom nav walker to match the provided HTML structure
 */
class Custom_Walker_Nav_Menu extends Walker_Nav_Menu
{

   /**
    * Starts the list before the elements are added.
    *
    * @param string   $output Used to append additional content.
    * @param int      $depth  Depth of menu item.
    * @param stdClass $args   An object of wp_nav_menu() arguments.
    */
   public function start_lvl(&$output, $depth = 0, $args = null)
   {
      if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
         $t = '';
         $n = '';
      } else {
         $t = "\t";
         $n = "\n";
      }
      $indent = str_repeat($t, $depth);

      // Default class for sub-menu
      $classes = array('sub-menu');

      /**
       * Filters the CSS class(es) applied to a menu list element.
       *
       * @param string[] $classes Array of the CSS classes that are applied to the menu `<ul>` element.
       * @param stdClass $args    An object of `wp_nav_menu()` arguments.
       * @param int      $depth   Depth of menu item. Used for padding.
       */
      $class_names = join(' ', apply_filters('nav_menu_submenu_css_class', $classes, $args, $depth));
      $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

      $output .= "{$n}{$indent}<ul$class_names>{$n}";
   }

   /**
    * Starts the element output.
    *
    * @param string   $output Used to append additional content (passed by reference).
    * @param WP_Post  $item   Menu item data object.
    * @param int      $depth  Depth of menu item. Used for padding.
    * @param stdClass $args   An object of wp_nav_menu() arguments.
    * @param int      $id     Current item ID.
    */
   public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
   {
      if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
         $t = '';
         $n = '';
      } else {
         $t = "\t";
         $n = "\n";
      }
      $indent = ($depth) ? str_repeat($t, $depth) : '';

      $classes = empty($item->classes) ? array() : (array) $item->classes;

      // Add 'current-menu-item' class if item is current
      if (in_array('current-menu-item', $classes)) {
         $classes[] = 'current-menu-item';
      }

      // Add 'has-children' class if item has children
      if ($this->has_children) {
         $classes[] = 'has-children';
      }

      /**
       * Filters the arguments for a single nav menu item.
       *
       * @param stdClass $args  An object of wp_nav_menu() arguments.
       * @param WP_Post  $item  Menu item data object.
       * @param int      $depth Depth of menu item. Used for padding.
       */
      $args = apply_filters('nav_menu_item_args', $args, $item, $depth);

      // Remove unnecessary WordPress classes
      $unwanted_classes = array(
         'menu-item',
         'menu-item-type-post_type',
         'menu-item-object-page',
         'menu-item-has-children',
         'page_item',
         'page-item-' . $item->ID,
         'current_page_item',
      );

      foreach ($unwanted_classes as $unwanted_class) {
         $key = array_search($unwanted_class, $classes);
         if (false !== $key) {
            unset($classes[$key]);
         }
      }

      // Add back necessary classes
      $classes[] = 'menu-item-' . $item->ID;
      if ($this->has_children && $depth === 0) {
         $classes[] = 'has-children';
      }

      $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
      $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

      $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
      $id = $id ? ' id="' . esc_attr($id) . '"' : '';

      $output .= $indent . '<li' . $id . $class_names . '>';

      $atts = array();
      $atts['title']  = ! empty($item->attr_title) ? $item->attr_title : '';
      $atts['target'] = ! empty($item->target)     ? $item->target     : '';
      $atts['rel']    = ! empty($item->xfn)        ? $item->xfn        : '';
      $atts['href']   = ! empty($item->url)        ? $item->url        : '';

      // If no title is set, use empty string
      $atts['title'] = $atts['title'] ?: '';

      /**
       * Filters the HTML attributes applied to a menu item's anchor element.
       *
       * @param array $atts {
       *     The HTML attributes applied to the menu item's `<a>` element, empty strings are omitted.
       *
       *     @type string $title  Title attribute.
       *     @type string $target Target attribute.
       *     @type string $rel    The rel attribute.
       *     @type string $href   The href attribute.
       * }
       * @param WP_Post  $item  The current menu item.
       * @param stdClass $args  An object of wp_nav_menu() arguments.
       * @param int      $depth Depth of menu item. Used for padding.
       */
      $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

      $attributes = '';
      foreach ($atts as $attr => $value) {
         if (is_scalar($value) && '' !== $value && false !== $value) {
            $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
            $attributes .= ' ' . $attr . '="' . $value . '"';
         }
      }

      /** This filter is documented in wp-includes/post-template.php */
      $title = apply_filters('the_title', $item->title, $item->ID);

      /**
       * Filters a menu item's title.
       *
       * @param string   $title The menu item's title.
       * @param WP_Post  $item  The current menu item.
       * @param stdClass $args  An object of wp_nav_menu() arguments.
       * @param int      $depth Depth of menu item. Used for padding.
       */
      $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

      $item_output = $args->before;
      $item_output .= '<a' . $attributes . '>';
      $item_output .= $args->link_before . $title . $args->link_after;
      $item_output .= '</a>';
      $item_output .= $args->after;

      /**
       * Filters a menu item's starting output.
       *
       * The menu item's starting output only includes `$args->before`, the opening `<a>`,
       * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
       * no filter for modifying the opening and closing `<li>` for a menu item.
       *
       * @param string   $item_output The menu item's starting HTML output.
       * @param WP_Post  $item        Menu item data object.
       * @param int      $depth       Depth of menu item. Used for padding.
       * @param stdClass $args        An object of wp_nav_menu() arguments.
       */
      $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
   }

   /**
    * Ends the element output, if needed.
    *
    * @param string   $output Used to append additional content (passed by reference).
    * @param WP_Post  $item   Page data object. Not used.
    * @param int      $depth  Depth of page. Not used.
    * @param stdClass $args   An object of wp_nav_menu() arguments.
    */
   public function end_el(&$output, $item, $depth = 0, $args = null)
   {
      if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
         $t = '';
         $n = '';
      } else {
         $t = "\t";
         $n = "\n";
      }
      $output .= "</li>{$n}";
   }

   /**
    * Ends the list of after the elements are added.
    *
    * @param string   $output Used to append additional content (passed by reference).
    * @param int      $depth  Depth of menu item. Used for padding.
    * @param stdClass $args   An object of wp_nav_menu() arguments.
    */
   public function end_lvl(&$output, $depth = 0, $args = null)
   {
      if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
         $t = '';
         $n = '';
      } else {
         $t = "\t";
         $n = "\n";
      }
      $indent = str_repeat($t, $depth);
      $output .= "$indent</ul>{$n}";
   }
}
