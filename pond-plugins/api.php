<?php

add_action( 'rest_api_init', function () {
    register_rest_route( 'autogenerate/v1', 'page-templates', array(
      'methods' => 'GET',
      'callback' => function() {
          return wp_get_theme()->get_page_templates();
      },
		'permission_callback' => function() {
            return true;
        }
    ) );
	
	register_rest_route( 'autogenerate/v1', 'sitemap-generate', array(
      'methods' => 'POST',
      'callback' => function() {
		  if( class_exists( 'Smartcrawl_Sitemap_Cache' )) {
			Smartcrawl_Sitemap_Cache::get()->invalidate();
      		return 1;	  
		  }
		  
		  return 0;
	  },
		'permission_callback' => function() {
            return true;
        }
    ) );
    
    // wp rocket api
    register_rest_route( 'autogenerate/v1', 'wp-rocket', array(
      'methods' => 'POST',
      'callback' => function($request) {
          $tasks = [];

          // clear specific post from domain and slug
          if($request['clear_post'] && $request['domain'] && $request['slug']) {
              $url = "https://".$request['domain']."/".$request['slug'];
              rocket_clean_post( url_to_postid ( $url ) );
              $tasks[] = "$url has been cleared.";
          }

          // clear whole domain cache
          if($request['clear_domain'] && function_exists( 'rocket_clean_domain' )) {
              rocket_clean_domain();
              $tasks[] = "Domain cache has been cleared.";
          }

          // clear css and js files
          if($request['clear_css_js'] && function_exists( 'rocket_clean_minify' )) {
              rocket_clean_minify();
              $tasks[] = "CSS and JS files has been cleaned.";
          }

          // clear preload cache
          if($request['preload_cache'] && function_exists( 'run_rocket_sitemap_preload' )) {
              run_rocket_sitemap_preload();
              $tasks[] = "Cache has been preloaded.";
          }
		  
		  // flush cache wp
		  wp_cache_flush();

          return [
              'message' => 'wp_rocket',
              'tasks' => $tasks
          ];
      },
        'permission_callback' => function() {
            return true;
        }
    ) );
	
	
	
	// nitropack api
    register_rest_route( 'autogenerate/v1', 'nitropack', array(
      'methods' => 'POST',
      'callback' => function($request) {
          $tasks = [];

          // clear specific post from domain and slug
          if($request['clear_post'] && $request['domain'] && $request['slug'] && function_exists( 'nitropack_sdk_purge' )) {
              $url = "https://".$request['domain']."/".$request['slug'];
              $postUrl = nitropack_sanitize_url_input($url);
              $reason = "Manual purge of " . $postUrl;
              try {
                if (nitropack_sdk_purge($postUrl, NULL, $reason)) {
                    $tasks[] = $reason;
                }
            } catch (\Exception $e) {}
          }

          // clear whole domain cache
          if($request['clear_domain'] && function_exists( 'nitropack_sdk_purge' )) {
              $reason = 'Manual purge of all pages';
              try {
                  if (nitropack_sdk_purge(NULL, NULL, 'Manual purge of all pages')) {
                      $tasks[] = $reason;
                  }
              } catch (\Exception $e) {}
          }
		  
		  // flush cache wp
		  wp_cache_flush();
		  
          return [
              'message' => 'nitropack',
              'tasks' => $tasks
          ];
      },
        'permission_callback' => function() {
            return true;
        }
    ) );
    // end of nitropack api clear cache

} );