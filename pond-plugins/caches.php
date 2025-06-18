<?php

function ons_delete_transient() {
  // clear redis memcache
  if (function_exists('wp_cache_flush')) {
    wp_cache_flush();
  }

  // Delete all transients
  global $wpdb;
  $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_transient_%'");
  $wpdb->query("DELETE FROM $wpdb->options WHERE option_name LIKE '_site_transient_%'");
}

function ons_clear_all_wordpress_cache() {

  $tasks = array();

  // Delete all transients
  ons_delete_transient();
  $tasks[] = "Clear transients";

  // WP Super Cache
  if (function_exists('wp_cache_clear_cache')) {
    wp_cache_clear_cache();
    $tasks[] = "WP Super Cache";
  }

  // W3 Total Cache
  if (function_exists('w3tc_flush_all')) {
    w3tc_flush_all();
    $tasks[] = "W3 Total Cache";
  }

  // WP Fastest Cache
  if (class_exists('WpFastestCache')) {
    $wpfc = new WpFastestCache();
    $wpfc->deleteCache();
    $tasks[] = "WP Fastest Cache";
  }

  // LiteSpeed Cache
  if (class_exists('LiteSpeed_Cache_API')) {
    LiteSpeed_Cache_API::purge_all();
    $tasks[] = "LiteSpeed Cache";
  }

  // Autoptimize
  if (class_exists('autoptimizeCache')) {
    autoptimizeCache::clearall();
    $tasks[] = "Autoptimize Cache";
  }

  // WP Rocket
  if (function_exists('rocket_clean_domain')) {
    rocket_clean_domain();
    $tasks[] = "WP Rocket Cache";
  }

  // Breeze (Cloudways)
  if (class_exists('Breeze_PurgeCache')) {
    Breeze_PurgeCache::breeze_cache_flush();
    $tasks[] = "Breeze Cache";
  }

  // Hummingbird
  if (class_exists('Hummingbird\WP_Hummingbird')) {
    \Hummingbird\WP_Hummingbird::flush_cache();
    $tasks[] = "Hummingbird Cache";
  }
  return $tasks;
}


function ons_clear_cache_for_specific_url($url) {

  $tasks = array();

  // Delete all transients
  ons_delete_transient();
  $tasks[] = "Clear transients";

  // WP Rocket
  if (function_exists('rocket_clean_files')) {
    rocket_clean_post( url_to_postid ( $url ) );
    rocket_clean_files([$url]);
    $tasks[] = "WP Rocket Cache";
  }

  // LiteSpeed Cache
  if (class_exists('LiteSpeed_Cache_API')) {
    LiteSpeed_Cache_API::purge($url);
    $tasks[] = "LiteSpeed Cache";
  }

  // WP Super Cache
  if (function_exists('wp_cache_post_change')) {
      // Attempt to get post ID from URL
    $post_id = url_to_postid($url);
    if ($post_id) {
      wp_cache_post_change($post_id);
      $tasks[] = "WP Super Cache";
    }
  }

  // W3 Total Cache
  if (function_exists('w3tc_flush_url')) {
    w3tc_flush_url($url);
    $tasks[] = "W3 Total Cache";
  }

  // Autoptimize (no URL-level clearing, clear all instead)
  if (class_exists('autoptimizeCache')) {
    autoptimizeCache::clearall();
    $tasks[] = "Autoptimize Cache";
  }

  // WP Fastest Cache (no specific URL support, clear all)
  if (class_exists('WpFastestCache')) {
    $wpfc = new WpFastestCache();
    $wpfc->deleteCache(); // No URL targeting support
    $tasks[] = "WP Fastest Cache";
  }

  // Breeze (Cloudways)
  if (class_exists('Breeze_PurgeCache')) {
    Breeze_PurgeCache::breeze_cache_flush(); // No single URL purge
    $tasks[] = "Breeze Cache";
  }

  // Hummingbird (no single URL purge, flush all)
  if (class_exists('Hummingbird\WP_Hummingbird')) {
    \Hummingbird\WP_Hummingbird::flush_cache();
    $tasks[] = "Hummingbird Cache";
  }
  return $tasks;
}