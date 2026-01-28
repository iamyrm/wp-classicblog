<?php

/**
 * Template Name: About Page
 */

get_header();

$post_id = get_the_ID();

if (has_post_thumbnail()) {
   $thumbnail = get_the_post_thumbnail_url($post_id);
} else {
   $thumbnail = get_template_directory_uri() . '/assets/default.jpg';
}
?>

<div id="content" class="s-content s-content--page">
   <section>
      <div class="row entry-wrap">
         <div class="column lg-12">
            <article class="entry">
               <header class="entry__header entry__header--narrow">

                  <h1 class="entry__title">
                     <?php echo esc_html(get_the_title()); ?>
                  </h1>
               </header>

               <div class="entry__media">
                  <figure class="featured-image">
                     <img src="<?php echo esc_url($thumbnail); ?>"
                        sizes="(max-width: 2400px) 100vw, 2400px" alt="<?php echo esc_html(the_title()); ?>">
                  </figure>
               </div>

               <div class="content-primary">
                  <div class="entry__content">
                        <?php echo get_the_content(); ?>
                  </div>
               </div>
            </article>
         </div>
      </div>
   </section>
</div>

<?php get_footer(); ?>