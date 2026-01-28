<?php
get_header();
$post_id = get_the_ID();
$author_id = get_post_field('post_author', $post_id);
$author_name = get_the_author_meta('display_name', $author_id);
$author_link = get_author_posts_url($author_id);
$categories = get_the_category($post_id);
$category_name = !empty($categories) ? $categories[0]->name : 'Uncategorized';
$category_link = !empty($categories) ? get_category_link($categories[0]->term_id) : '#';
$tags = get_the_tags($post_id);
$thumbnail = has_post_thumbnail() ? get_the_post_thumbnail_url($post_id) : get_template_directory_uri() . '/assets/default.jpg';
$prev_post = get_previous_post();
$next_post = get_next_post();
?>

<div id="content" class="s-content s-content--blog">
   <section>
      <div class="row entry-wrap">
         <div class="column lg-12">

            <article class="entry format-standard">

               <header class="entry__header">

                  <h1 class="entry__title">
                     <?php echo esc_html(get_the_title()); ?>
                  </h1>

                  <div class="entry__meta">
                     <div class="entry__meta-author">
                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                           <circle cx="12" cy="8" r="3.25" stroke="currentColor" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="1.5"></circle>
                           <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="1.5"
                              d="M6.8475 19.25H17.1525C18.2944 19.25 19.174 18.2681 18.6408 17.2584C17.8563 15.7731 16.068 14 12 14C7.93201 14 6.14367 15.7731 5.35924 17.2584C4.82597 18.2681 5.70558 19.25 6.8475 19.25Z">
                           </path>
                        </svg>

                        <?php  /* <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"> */ ?>
                        <a href="#">
                           <?php echo esc_html($author_name); ?>
                        </a>
                     </div>
                     <div class="entry__meta-date">
                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                           <circle cx="12" cy="12" r="7.25" stroke="currentColor" stroke-width="1.5">
                           </circle>
                           <path stroke="currentColor" stroke-width="1.5" d="M12 8V12L14 14"></path>
                        </svg>
                        <?php echo get_the_date(); ?>
                     </div>
                     <div class="entry__meta-cat">
                        <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                           <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="1.5"
                              d="M19.25 17.25V9.75C19.25 8.64543 18.3546 7.75 17.25 7.75H4.75V17.25C4.75 18.3546 5.64543 19.25 6.75 19.25H17.25C18.3546 19.25 19.25 18.3546 19.25 17.25Z">
                           </path>
                           <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="1.5"
                              d="M13.5 7.5L12.5685 5.7923C12.2181 5.14977 11.5446 4.75 10.8127 4.75H6.75C5.64543 4.75 4.75 5.64543 4.75 6.75V11">
                           </path>
                        </svg>

                        <span class="cat-links">
                           <a href="<?php echo esc_html($category_link); ?>"><?php echo esc_html($category_name); ?></a>
                        </span>
                     </div>
                  </div>
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

                     <p class="entry__tags">
                        <strong>Tags:</strong>

                        <span class="entry__tag-list">
                           <?php
                           if ($tags) {
                              foreach ($tags as $tag) {
                                 echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '">' . esc_html($tag->name) . '</a>';
                              }
                           } else {
                              echo 'No tags';
                           }
                           ?>
                        </span>
                     </p>

                  </div> <!-- end entry-content -->

                  <div class="post-nav">
                     <div class="post-nav__prev">
                        <?php if ($prev_post): ?>
                           <a href="<?php echo get_permalink($prev_post->ID); ?>" rel="prev">
                              <span>Prev</span>
                              <?php echo esc_html(get_the_title($prev_post->ID)); ?>
                           </a>
                        <?php endif; ?>
                     </div>
                     <div class="post-nav__next">
                        <?php if ($next_post): ?>
                           <a href="<?php echo get_permalink($next_post->ID); ?>" rel="next">
                              <span>Next</span>
                              <?php echo esc_html(get_the_title($next_post->ID)); ?>
                           </a>
                        <?php endif; ?>
                     </div>
                  </div>
               </div>
            </article>
         </div>
      </div> <!-- end entry-wrap -->
   </section> <!-- end s-content -->

</div>

<?php get_footer(); ?>