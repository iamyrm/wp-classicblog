<?php get_header(); ?>

<section id="content" class="s-content">
   <!-- pageheader -->
   <div class="s-pageheader">
      <div class="row">
         <div class="column large-12">
            <h1 class="page-title">
               <span class="page-title__small-type">Category:</span>
               <?php single_cat_title(); ?>
            </h1>
         </div>
      </div>
   </div>

   <div id="bricks" class="bricks">
      <div class="masonry">
         <div class="bricks-wrapper" data-animate-block>
            <div class="grid-sizer"></div>
            <?php

            if (have_posts()):
               while (have_posts()):
                  the_post();

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
            ?>
         </div>
      </div>

      <!-- pagination -->
      <?php
      global $wp_query;
      $total_pages = $wp_query->max_num_pages;

      if ($total_pages > 1) {
         $current_page = max(1, get_query_var('paged'));
      ?>
         <div class="row pagination">
            <div class="column lg-12">
               <nav class="pgn">
                  <ul>
                     <?php
                     // Previous page link
                     if ($current_page > 1) {
                        echo '<li>';
                        echo '<a class="pgn__prev" href="' . get_pagenum_link($current_page - 1) . '">';
                        echo '<svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5" d="M10.25 6.75L4.75 12L10.25 17.25"></path>
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5" d="M19.25 12H5"></path>
                            </svg>';
                        echo '</a>';
                        echo '</li>';
                     }

                     // Page numbers
                     for ($i = 1; $i <= $total_pages; $i++) {
                        if ($current_page == $i) {
                           echo '<li><span class="pgn__num current">' . $i . '</span></li>';
                        } else {
                           echo '<li><a class="pgn__num" href="' . get_pagenum_link($i) . '">' . $i . '</a></li>';
                        }
                     }

                     // Next page link
                     if ($current_page < $total_pages) {
                        echo '<li>';
                        echo '<a class="pgn__next" href="' . get_pagenum_link($current_page + 1) . '">';
                        echo '<svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5" d="M13.75 6.75L19.25 12L13.75 17.25"></path>
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5" d="M19 12H4.75"></path>
                            </svg>';
                        echo '</a>';
                        echo '</li>';
                     }
                     ?>
                  </ul>
               </nav>
            </div>
         </div>
      <?php
      }
      ?>
      <!-- /pagination -->
   </div>

</section>

<?php get_footer(); ?>