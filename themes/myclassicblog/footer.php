 <!-- # site-footer ================================================== -->
 <footer id="colophon" class="s-footer">

<?php get_template_part('parts/subscription') ?>

    <div class="row s-footer__main">
       <div class="column lg-5 md-6 tab-12 s-footer__about">
          <h4><?php echo bloginfo('name'); ?></h4>
          <p><?php echo esc_html(get_theme_mod('setting_site_details1')) ?></p>
       </div>

      <?php get_template_part('parts/navbar','footer'); ?>
    </div>

    <?php
      get_template_part('parts/social_and_credit');
      get_template_part('parts/gototop');
      ?>

 </footer>
 </div>

 <?php wp_footer(); ?>

 </body>

 </html>