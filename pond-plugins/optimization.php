<?php

function ons_remove_unecessary_styles() {
  wp_deregister_style( 'wc-blocks-style' );
  wp_dequeue_style( 'wp-block-library' );
  wp_dequeue_style( 'wp-block-library-theme' );
  wp_dequeue_style( 'wc-blocks-style' );
}

add_action( 'wp_enqueue_scripts', "ons_remove_unecessary_styles", 100 );
remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');