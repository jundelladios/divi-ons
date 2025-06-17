<?php

$mapApi = carbon_get_theme_option('ponds_map_api');

if( $mapApi ): 

$scargs = shortcode_atts( array(
    'maptype' => 'roadmap',
    'height' => 600,
    'contentwidth' => 500,
    'primarycolor' => '#7b1fa2',
    'hovercolor' => '#4a0072',
    'secondarycolor' => '#00796b',
    'tertiarycolor' => '#387002',
    'perbatch' => 20,
    'piniconpaid' => get_stylesheet_directory_uri() . '/shortcodes/map/src/map-pin-paid.png',
    'piniconunpaid' => get_stylesheet_directory_uri() . '/shortcodes/map/src/map-pin-unpaid.png',
    'tags' => 1,
    'state' => 1,
    'statevalue' => null,
    'tagvalue' => null,
    'mainbg' => '#7b1fa2',
    'maincolor' => '#ffffff',
    'lat' => 37.8393332,
    'lng' => -84.2700179,
    'clustersize' => 26,
    'zoom' => 8,
    'servicestates' => ''
  ), $args );

  $unid = wp_unique_id('map_generator_sc_');

  $mapGenModule = "MapGenModule_$unid";

  require_once get_stylesheet_directory() . '/shortcodes/map/inc/enqueue.php';

  require_once get_stylesheet_directory() . '/shortcodes/map/inc/script.php';

  require_once get_stylesheet_directory() . '/shortcodes/map/inc/style.php';

  require_once get_stylesheet_directory() . '/shortcodes/map/inc/template.php';

endif;