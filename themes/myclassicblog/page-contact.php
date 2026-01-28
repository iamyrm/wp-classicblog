<?php

/**
 * Template Name: Contact Page
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
                     <?php echo esc_html(the_title()); ?>
                  </h1>

               </header>

               <div class="entry__media">
                  <figure class="featured-image">
                     <img src="<?php echo esc_url($thumbnail); ?>"
                        sizes="(max-width: 2400px) 100vw, 2400px" alt="">
                  </figure>
               </div>

               <div class="content-primary">

                  <div class="entry__content">

                     <?php echo get_the_content(); ?>

                     <div class="row block-large-1-2 block-tab-whole entry__blocks">
                        <div class="column">
                           <h4>Where to Find Us</h4>
                           <p>
                              <?php echo esc_html(get_theme_mod('setting_site_details8')); ?>
                           </p>
                        </div>

                        <div class="column">
                           <h4>Contact Info</h4>
                           <p>
                              <?php echo esc_html(get_theme_mod('setting_site_details9')) ?><br>
                              <?php echo esc_html(get_theme_mod('setting_site_details10')) ?> <br>
                              Phone: <?php echo esc_html(get_theme_mod('setting_site_details11')) ?>
                           </p>
                        </div>
                     </div>

                     <h4>Feel Free to Say Hi.</h4>

                     <form name="cForm" id="cForm" class="entry__form" method="post" action="" autocomplete="off">
                        <?php wp_nonce_field('contact_form_submit', 'contact_form_nonce'); ?>
                        <fieldset class="row">

                           <div class="column lg-6 tab-12 form-field">
                              <input name="cName" id="cName" class="u-fullwidth" placeholder="Your Name" value="" type="text" required>
                           </div>

                           <div class="column lg-6 tab-12 form-field">
                              <input name="cEmail" id="cEmail" class="u-fullwidth" placeholder="Your Email" value="" type="email" required>
                           </div>

                           <div class="column lg-12 form-field">
                              <input name="cWebsite" id="cWebsite" class="u-fullwidth" placeholder="Website" value="" type="url">
                           </div>

                           <div class="column lg-12 message form-field">
                              <textarea name="cMessage" id="cMessage" class="u-fullwidth" placeholder="Your Message" required></textarea>
                           </div>

                           <div class="column lg-12">
                              <input name="submit" id="submit" class="btn btn--primary btn-wide btn--large u-fullwidth" value="Add Comment" type="submit">
                           </div>

                        </fieldset>
                     </form>
                     
                  </div>
            </article>
         </div>
      </div>
   </section>

</div>

<?php get_footer(); ?>