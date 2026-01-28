<?php get_header(); ?>

<!-- # site-content------------- -->
<section id="content" class="s-content">

   <?php
   get_template_part("parts/home", "hero");
   get_template_part("parts/home", "blog");
   ?>

</section>

<?php get_footer(); ?>