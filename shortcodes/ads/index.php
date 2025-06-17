<?php

$scargs = shortcode_atts( array(
    'perbatch' => 6,
    'membership_id' => null,
    'statevalue' => ''
  ), $args );

  $apiRequest = carbon_get_theme_option('portal_admin') . "/api/v1/customer";

  $params = [
    'limit' => $scargs['perbatch'],
    'page' => 1,
    'ishidden' => 0,
    'withbannersonly' => 1,
    'orderby' => 'membership.priority DESC'
  ];

  if( $scargs['statevalue'] ) {

    $params['state'] = $scargs['statevalue'];

  }

  if($scargs['membership_id']) {

      $params['membership_id'] = $scargs['membership_id'];

  }

  $unid = wp_unique_id('banner_ads_sc_');

  $apiRequest = carbon_get_theme_option('portal_admin') . "/api/v1/customer?" . http_build_query($params);
  $response = wp_remote_get( $apiRequest );
  $customers     = json_decode( wp_remote_retrieve_body( $response ), true );

  if( isset( $customers['data'] ) ):

  $totalcs = count($customers['data']);

  //require_once get_stylesheet_directory() . '/shortcodes/grid/style.php';

  endif;

?>