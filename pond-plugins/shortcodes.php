<?php

function custom_generator_enqueue_scripts() {

    global $post;
    
    if( is_a( $post, 'WP_Post' ) && (has_shortcode( $post->post_content, 'mapgenerator') || has_shortcode( $post->post_content, 'gridgenerator')) ) {

        wp_enqueue_style( 'generator-sc', get_stylesheet_directory_uri() . '/shortcodes/generator-sc.css' );

        $mapApi = carbon_get_theme_option('ponds_map_api');

        if( $mapApi ): 

        wp_register_script( 'map-generator-shortcode', "https://maps.googleapis.com/maps/api/js?key=$mapApi&v=beta" );

        wp_register_script( 'map-generator-cluster', get_stylesheet_directory_uri() . '/shortcodes/map/src/markercluster.js' );

        endif;

    }

  }

  add_action( 'wp_enqueue_scripts', 'custom_generator_enqueue_scripts' );
  

function custom_generator_map_shortcode( $atts = array() ) {

  ob_start();
  
  get_template_part( 'shortcodes/map/map', 'reusable-component', $atts );

  return ob_get_clean();

}

add_shortcode('mapgenerator', 'custom_generator_map_shortcode');



function custom_generator_grid_shortcode( $atts = array() ) {

  ob_start();
  
  get_template_part( 'shortcodes/grid/grid', 'reusable-component', $atts );

  return ob_get_clean();

}

add_shortcode('gridgenerator', 'custom_generator_grid_shortcode');



function custom_banner_ads_shortcode( $atts = array() ) {

  ob_start();
  
  get_template_part( 'shortcodes/ads/index', 'reusable-component', $atts );

  return ob_get_clean();

}

add_shortcode('bannerads', 'custom_banner_ads_shortcode');



function custom_url_encoder( $str ) {

  return str_replace(' ', '%20', $str);

}


function custom_query_params_shortcode( $atts = array() ) {

  $scargs = shortcode_atts( array(
    'key' => null
  ), $atts);

  return !isset($_GET[$scargs['key']]) || !$scargs['key'] ? home_url('/') : $_GET[$scargs['key']];

}

add_shortcode('queryparam', 'custom_query_params_shortcode');