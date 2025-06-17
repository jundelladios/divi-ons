<?php

// contractor finder shortcode

function custom_find_contractor_filter_query_vars_filter( $vars ){
    $vars[] = "zipcode";
    $vars[] = "unit";
    $vars[] = "radius";
    $vars[] = "sv";
    $vars[] = "showServices";
    $vars[] = "showMap";
    $vars[] = "filter";
    return $vars;
}
  
add_filter( 'query_vars', 'custom_find_contractor_filter_query_vars_filter' );

/** embed assets if this shortcode has been added to post */
function custom_find_contractor_filter_scripts() {
  global $post;
  if( is_a( $post, 'WP_Post' ) && (has_shortcode( $post->post_content, 'contractor-finder') || has_shortcode( $post->post_content, 'contractor-finder')) ) {
      $mapApi = carbon_get_theme_option('ponds_map_api');
      if( $mapApi ): 
      wp_enqueue_script( 'map-generator-shortcode-findcontractor', "https://maps.googleapis.com/maps/api/js?key=$mapApi&libraries=marker&v=beta",array(),null,true );
      wp_enqueue_script( 'map-generator-cluster', get_stylesheet_directory_uri() . '/shortcodes/map/src/markercluster.js',array(),null,true );
      wp_enqueue_script( 'map-generator-cookie', get_stylesheet_directory_uri() . '/assets/js-cookie.js', '', '', true );
      endif;
      wp_enqueue_style( 'find-contractor-style', get_stylesheet_directory_uri() . '/assets/contractor-finder.css' );
      wp_enqueue_script( 'find-contractor-js', get_stylesheet_directory_uri() . '/assets/contractor-finder.js', '', '', true);
  }
}
add_action( 'wp_enqueue_scripts', 'custom_find_contractor_filter_scripts' );


function custom_find_contractor_filter_shortcode( $atts = array() ) {
  ob_start();
  require_once get_stylesheet_directory() . '/domains.php';
  $atts['domainconfigs'] = $domainconfigs;
  get_template_part( 'shortcodes/contractor-finder/index', 'reusable-component', $atts );
  return ob_get_clean();
}
add_shortcode('contractor-finder', 'custom_find_contractor_filter_shortcode');


function onds_custom_cookie_parser( $name ) {
  if(!isset($_COOKIE[$name])) {
    return null;
  }
  return json_decode(str_replace("\\", "",$_COOKIE[$name]));
}


function custom_geocode_client_ip() {
  if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
  } elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
  } else {
    $ip = $_SERVER['REMOTE_ADDR'];
  }
  return $ip;
}

// end of contractor finder code