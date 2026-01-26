<div class="column lg-5 md-6 tab-12">
   <div class="row">
      <?php for ($counter = 1; $counter < 3; $counter++): ?>
         <div class="column lg-6">
            <?php if (has_nav_menu("footer_menu_$counter")): ?>
               <h4>Menu <?php echo $counter; ?></h4>
               <?php
               wp_nav_menu(array(
                  "theme_location" => "footer_menu_$counter",
                  "depth" => 0,
                  "menu_class" => "link-list",
                  "conatiner" => false,
                  "fallback_cb" => false
               ));
               ?>
            <?php endif; ?>
         </div>
      <?php endfor; ?>
   </div>
</div>