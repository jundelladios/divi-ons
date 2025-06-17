<?php
/* 
Template Name: Auto-Generate-County
*/

require_once get_stylesheet_directory().'/auto-generate-county/config.php';

require_once get_stylesheet_directory().'/domains.php';

get_header();

?>

<script>window.slickoptions = {
        autoplay: true,
        autoplaySpeed: 5000,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: false,
        arrows: false,
        adaptiveHeight: true
    };</script>

<div id="dev-auto-generate-state" class="dev-auto-generate-state">
	<?php
		get_template_part( 'auto-generate-county/templates/sections/section-1' );
	?>
	<?php
		get_template_part( 'globals/county-breadcrumb' );
	?>
	<?php
		get_template_part( 'auto-generate-county/templates/sections/section-2' );
	?>
	<?php
		get_template_part( 'auto-generate-county/templates/sections/section-3' );
	?>
	<?php
		get_template_part( 'auto-generate-county/templates/sections/section-4' );
	?>
	<?php
		get_template_part( 'auto-generate-county/templates/sections/domains' );
	?>
</div>

<?php

get_template_part( 'auto-generate-county/grid-script' );

get_footer();