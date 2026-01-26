<div class="row s-header__navigation">
   <nav class="s-header__nav-wrap">
      <h3 class="s-header__nav-heading">Navigate to</h3>
      <?php
      if (has_nav_menu('header_menu')) {
         wp_nav_menu(array(
            'theme_location' => 'header_menu',
            'container'      => false,
            'menu_class'     => 's-header__nav',
            'fallback_cb'    => false,
            'depth'          => 2,
            'walker'         => new Custom_Walker_Nav_Menu(),
            'items_wrap'     => '<ul class="s-header__nav">%3$s</ul>'
         ));
      }
      ?>
   </nav>
</div>