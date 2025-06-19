<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

  add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
  function crb_attach_theme_options() {

    $onddefaultdomainconfigs = array(
        array(
            'pond_domain_service_domain' => 'outdoor-network.services',
            'pond_domain_service_title' => 'Outdoor Network'
        ),
        array(
            'pond_domain_service_domain' => 'garden-center.outdoor-network.services',
            'pond_domain_service_title' => 'Garden Center'
        ),
        array(
            'pond_domain_service_domain' => 'pond-contractor.outdoor-network.services',
            'pond_domain_service_title' => 'Pond Contractor'
        ),
        array(
            'pond_domain_service_domain' => 'pond-maintenance.outdoor-network.services',
            'pond_domain_service_title' => 'Pond Maintenance'
        ),
        array(
            'pond_domain_service_domain' => 'lawn-landscape.outdoor-network.services',
            'pond_domain_service_title' => 'Lawn & Landscape Contractors (LCS)'
        ),
        array(
            'pond_domain_service_domain' => 'outdoor-living.outdoor-network.services',
            'pond_domain_service_title' => 'Outdoor Living Services'
        ),
        array(
            'pond_domain_service_domain' => 'swimming-pool.outdoor-network.services',
            'pond_domain_service_title' => 'Swimming Pool'
        ),
        array(
            'pond_domain_service_domain' => 'deck-patio.outdoor-network.services',
            'pond_domain_service_title' => 'Deck Patio'
        ),
        array(
            'pond_domain_service_domain' => 'atlantic-oase-apc.outdoor-network.services',
            'pond_domain_service_title' => 'Atlantic Oase APC'
        ),
    );

      Container::make( 'theme_options', __( 'POND Options' ) )
        ->add_fields( array(
            Field::make( 'text', 'ponds_image_cdn', 'Enter ShortPixel AI CDN' )
            ->set_attribute( 'placeholder', 'https://cdn.shortpixel.ai/client' )
          ->set_default_value( 'https://cdn.shortpixel.ai/client' ),
        ) )
        ->add_fields( array(
            Field::make( 'text', 'portal_admin', 'Enter Auto-Generate Landing Page Admin URL' )
            ->set_default_value( 'https://generator.outdoor-network.services' )
        ) )
        ->add_fields( array(
            Field::make( 'text', 'ponds_map_api', 'Enter Google Map API' )
            ->set_default_value( '' )
        ) )
        ->add_fields( array(
            Field::make( 'text', 'ponds_inquiry_url', 'Enter Inquiry URL' )
            ->set_default_value( 'https://outdoor-network.services/request-a-quote/' )
        ) )
        ->add_fields( array(
            Field::make( 'text', 'ponds_retailer_url', 'Enter Retailer URL' )
            ->set_default_value( 'https://outdoor-network.services/contractor-locator/' )
        ) )
        ->add_fields( array(
          Field::make( 'text', 'ponds_form_webhook', 'Enter Webhook URL' )
          ->set_default_value( home_url('/thank-you') )
        ) )
        ->add_fields( array(
          Field::make( 'text', 'ponds_recaptcha_sitekey', 'Enter reCAPTCHA Site Key' )
          ->set_default_value( '' )
        ) )
        ->add_fields( array(
          Field::make( 'text', 'ponds_terms_url', 'Enter Terms URL' )
          ->set_default_value( 'https://outdoor-network.services/terms-of-use' )
        ) )
        ->add_fields( array(
          Field::make( 'text', 'ponds_phone_mask', 'Phone Masking' )
          ->set_default_value( '(999) 999-9999' )
        ) )
        ->add_fields( array(
          Field::make( 'text', 'ponds_locator_text', 'Locator Text' )
          ->set_default_value( 'Find a Locator' )
        ) )
        ->add_fields( array(
          Field::make( 'text', 'ponds_locator_page_url', 'Locator Page URL' )
          ->set_default_value( home_url('/find-a-business') )
        ) )


        // search feature starts here
        ->add_fields( array(
          Field::make( 'textarea', 'ponds_filter_units', 'Filter Units' )
          ->set_default_value( "mi[default]\nkm" )
        ) )

          
        ->add_fields( array(
          Field::make( 'textarea', 'ponds_filter_radius', 'Filter Radius' )
          ->set_default_value( "10\n20[default]\n50\n100" )
        ) )

        ->add_fields( array(
          Field::make( 'select', 'ponds_icon_package', 'Select Icon Package' )
          ->add_options( array(
              'fa' => 'Font Awesome',
              'et' => 'Elegant Themes'
          ) )
          ->set_default_value( 'et' )
        ) )

        ->add_fields( array(
          Field::make( 'complex', 'ponds_domain_services', 'Domain Services', __( '' ) )
          ->set_collapsed( true )
          ->add_fields( array(
              Field::make( 'text', 'pond_domain_service_domain', 'Domain' ),
              Field::make( 'text', 'pond_domain_service_title', 'Domain Title' )
          ))
          ->set_header_template( 'Domain Service (<%- pond_domain_service_domain %>)' )
          ->set_default_value( $onddefaultdomainconfigs )
        ) )

        // end of search feature

        ;
  }
  
  add_action( 'after_setup_theme', 'crb_load' );
  function crb_load() {
      require_once( get_stylesheet_directory().'/vendor/autoload.php' );
      \Carbon_Fields\Carbon_Fields::boot();
  }