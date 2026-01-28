<?php

function ya_classicblog($wp_customize)
{
   $wp_customize->add_section(
      'section_header_and_footer',
      array(
         'title' => 'Header and Footer Section',
         'description' => 'Header and Footer Section details',
      )
   );

   /* 
    1 => Site Description
    2 => Facebook link
    3 => X link
    4 => Instagram link
    5 => Pinterest link
    6 => Footer Menu 1
    7 => Footer Menu 2
    8 => Address
    9 => Website
    10 => Email
    11 => Phone
    */

   for ($i = 1; $i <= 11; $i++) {
      $labels = array(
         '1' => 'Site Description',
         '2' => 'Facebook link',
         '3' => 'X link',
         '4' => 'Instagram link',
         '5' => 'Pinterest link',
         '6' => 'Footer Menu 1',
         '7' => 'Footer Menu 2',
         '8' => 'Address',
         '9' => 'Website',
         '10' => 'Email',
         '11' => 'Phone'
      );

      $label = $labels[$i];

      $wp_customize->add_setting(
         "setting_site_details$i",
         array(
            'type' => 'theme_mod',
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field'
         )
      );

      $wp_customize->add_control(
         "setting_site_details$i",
         array(
            'label' => $label,
            'description' => "Please enter $label details.",
            'section' => 'section_header_and_footer',
            'type' => ($i !== 1) ? 'text' : 'textarea'
         )
      );
   }
}

add_action('customize_register', 'ya_classicblog');
