<div id="bricks" class="bricks">
   <div class="masonry">
      <div class="bricks-wrapper" data-animate-block>
         <div class="grid-sizer"></div>

         <?php
         $args = array(
            'post_type'      => 'post',
            'posts_per_page' => 12,
            'offset'         => 3,
         );

         $my_query = new WP_Query($args);

         if ($my_query->have_posts()):
            while ($my_query->have_posts()):
               $my_query->the_post();

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
                  $thumbnail = get_the_post_thumbnail_url($post_id, 'blog-thumb');
               } else {
                  $thumbnail = get_template_directory_uri() . '/assets/default.jpg';
               }

         ?>

               <article class="brick entry" data-animate-el>

                  <div class="entry__thumb">
                     <a href="<?php echo esc_url($post_link); ?>" class="thumb-link">
                        <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($post_title); ?>">
                     </a>
                  </div>

                  <div class="entry__text">
                     <div class="entry__header">
                        <div class="entry__meta">
                           <span class="cat-links">
                              <a href="<?php echo esc_url($category_link); ?>">
                                 <?php echo esc_html($category_name); ?>
                              </a>
                           </span>
                           <span class="byline">
                              By:
                              <?php  /* <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"> */ ?>
                              <a href="#">
                                 <?php echo esc_html($author_name); ?>
                              </a>
                           </span>
                        </div>

                        <h1 class="entry__title">
                           <a href="<?php echo esc_url($post_link); ?>">
                              <?php echo esc_html($post_title); ?>
                           </a>
                        </h1>
                     </div>

                     <div class="entry__excerpt">
                        <p><?php echo esc_html($post_excerpt); ?></p>
                     </div>

                     <a class="entry__more-link" href="<?php echo esc_url($post_link); ?>">
                        Read More
                     </a>
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
   </div>

</div>