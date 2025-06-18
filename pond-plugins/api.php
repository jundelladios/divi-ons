<?php

function ons_referer_portal_api() {
  $portal = carbon_get_theme_option('portal_admin');
  $referer = $_SERVER['HTTP_REFERER'] ?? '';
  if(str_contains( $referer, $portal )) {
    return true;
  }
  return false;
}

add_action( 'rest_api_init', function () {
  register_rest_route( 'autogenerate/v1', 'page-templates', array(
    'methods' => 'GET',
    'callback' => function() {
      return wp_get_theme()->get_page_templates();
    },
  'permission_callback' => 'ons_referer_portal_api'
  ));
	
	register_rest_route( 'autogenerate/v1', 'sitemap-generate', array(
      'methods' => 'POST',
      'callback' => function() {
		  if( class_exists( 'Smartcrawl_Sitemap_Cache' )) {
			Smartcrawl_Sitemap_Cache::get()->invalidate();
      	return 1;	  
		  }
		  return 0;
	  },
		'permission_callback' => 'ons_referer_portal_api'
    ));
	
	
	// nitropack api
    register_rest_route( 'autogenerate/v1', 'nitropack', array(
      'methods' => 'POST',
      'callback' => function($request) {
        $tasks = [];

        // clear object cache memcache, redis
        if (function_exists('wp_cache_flush')) {
          wp_cache_flush();
          $tasks[] = "Clear object cache";
        }

        if($request['clear_post'] && $request['slug']) {
          $url = home_url($request['slug']);
          $cache = ons_clear_cache_for_specific_url( $url );
          $tasks = array_merge( $cache, $tasks );
          $tasks[] = "Clear $url cache";
        }

        if($request['clear_domain']) {
          $cache = ons_clear_all_wordpress_cache();
          $tasks = array_merge( $cache, $tasks );
          $tasks[] = "Clear domain cache";
        }
        
        return [
          'message' => 'nitropack',
          'tasks' => $tasks
        ];
      },
      'permission_callback' => 'ons_referer_portal_api'
    ));
    // end of nitropack api clear cache

} );