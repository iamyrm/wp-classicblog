<div class="hero">

   <div class="hero__slider swiper-container">

      <div class="swiper-wrapper">


         <?php
         $args = array(
            'post_type'      => 'post',
            'posts_per_page' => 3,
         );

         $my_hero_query = new WP_Query($args);

         if ($my_hero_query->have_posts()):
            while ($my_hero_query->have_posts()):
               $my_hero_query->the_post();

               $post_id = get_the_ID();
               $categories = get_the_category($post_id);
               $category_name = !empty($categories) ? $categories[0]->name : 'Uncategorized';
               $category_link = !empty($categories)
                  ? get_category_link($categories[0]->term_id)
                  : '#';
               $author_name = get_the_author_meta('display_name', get_the_author_meta('ID'));
               $post_link = get_permalink($post_id);
               $post_title = get_the_title($post_id);
               $post_excerpt = has_excerpt()
                  ? get_the_excerpt()
                  : wp_trim_words(get_the_content(), 18, '...');

               if (has_post_thumbnail()) {
                  $thumbnail = get_the_post_thumbnail_url($post_id, 'hero-thumb');
               } else {
                  $thumbnail = get_template_directory_uri() . '/assets/default.jpg';
               }

         ?>
               <article class="hero__slide swiper-slide">
                  <div class="hero__entry-image"
                     style="background-image: url('<?php echo esc_url($thumbnail); ?>')">
                  </div>
                  <div class="hero__entry-text">
                     <div class="hero__entry-text-inner">
                        <div class="hero__entry-meta">
                           <span class="cat-links">
                              <a href="<?php echo esc_url($category_link); ?>"><?php echo esc_html($category_name); ?></a>
                           </span>
                        </div>
                        <h2 class="hero__entry-title">
                           <a href="<?php echo esc_url($post_link); ?>">
                              <?php echo esc_html($post_title); ?>
                           </a>
                        </h2>
                        <p class="hero__entry-desc"><?php echo esc_html($post_excerpt); ?></p>
                        <a class="hero__more-link" href="<?php echo esc_url($post_link); ?>">Read More</a>
                     </div>
                  </div>
               </article>

            <?php
            endwhile;
         else :
            ?>
            <p>No Post Available.</p>
         <?php
         endif;

         wp_reset_postdata();
         ?>

      </div>

      <div class="swiper-pagination"></div>

   </div> <!-- end hero slider -->

   <a href="#bricks" class="hero__scroll-down smoothscroll">
      <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
         <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M10.25 6.75L4.75 12L10.25 17.25"></path>
         <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
            d="M19.25 12H5"></path>
      </svg>
      <span>Scroll</span>
   </a>

</div>