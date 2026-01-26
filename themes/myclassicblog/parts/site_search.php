<div class="s-header__search">
   <div class="s-header__search-inner">
      <div class="row">
         <form role="search" method="get" class="s-header__search-form" action="<?php echo esc_url(home_url('/')); ?>">
            <label>
               <span class="u-screen-reader-text"><?php echo esc_html_x('Search for:', 'label', 'ya_myclassicblog'); ?></span>
               <input type="search" class="s-header__search-field" placeholder="<?php echo esc_attr_x('Search for...', 'placeholder', 'ya_myclassicblog'); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x('Search for:', 'label', 'ya_myclassicblog'); ?>" autocomplete="off">
            </label>
            <input type="submit" class="s-header__search-submit" value="<?php echo esc_attr_x('Search', 'submit button', 'ya_myclassicblog'); ?>">
         </form>
         <a href="#0" title="Close Search" class="s-header__search-close">Close</a>
      </div>
   </div>
</div>

<a class="s-header__menu-toggle" href="#0"><span>Menu</span></a>

<a class="s-header__search-trigger" href="#">
   <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
         d="M19.25 19.25L15.5 15.5M4.75 11C4.75 7.54822 7.54822 4.75 11 4.75C14.4518 4.75 17.25 7.54822 17.25 11C17.25 14.4518 14.4518 17.25 11 17.25C7.54822 17.25 4.75 14.4518 4.75 11Z">
      </path>
   </svg>
</a>