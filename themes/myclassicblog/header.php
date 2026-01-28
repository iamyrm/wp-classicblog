<!DOCTYPE html>

<html <?php language_attributes(); ?> class="no-js">

<head>
   <?php wp_head(); ?>
</head>

<body <?php body_class(); ?> id="top">
   <?php wp_body_open(); ?>

   <?php get_template_part('parts/preloader'); ?>

   <div id="page" class="s-pagewrap <?php echo (is_home() || is_front_page()) ? 'ss-home' : ''; ?>">

      <header id="masthead" class="s-header">

         <div class="s-header__branding">
            <p class="site-title">
               <a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php echo bloginfo('name'); ?></a>
            </p>
         </div>

         <?php
         get_template_part('parts/navbar', 'header');
         get_template_part('parts/site_search');
         ?>
      </header>