<?php
/* 
Template Name: Auto-Generate
*/

require_once get_stylesheet_directory().'/auto-generate/config.php';

require_once get_stylesheet_directory().'/domains.php';

get_header();

?>

<div id="dev-template-v3" class="template-page-container">
	<?php
		get_template_part( 'auto-generate/templates/components/header' );
	?>
	<div class="template-main-content">
	<?php
		get_template_part( 'auto-generate/templates/sections/section-1' );
	?>

	<?php
		get_template_part( 'auto-generate/templates/sections/section-2' );
	?>

	<?php
		get_template_part( 'globals/contractor-breadcrumb' );
	?>


	<?php if( $apidata->ispaid ): ?>

	<?php
		get_template_part( 'auto-generate/templates/sections/section-3' );
	?>
	<?php
		get_template_part( 'auto-generate/templates/sections/section-4' );
	?>
	<?php
	if(!$apidata->membership_tb_hide_contact_form):
		get_template_part( 'auto-generate/templates/sections/section-5' );
	endif;
	?>

	<?php if( isset( $apidata->jsondata->pharalax[0] ) && is_object( $apidata->jsondata->pharalax[0] ) ): ?>
	<div id="parallax" style="background-image: url(<?php echo custom_url_encoder($apidata->jsondata->pharalax[0]->path); ?>);"></div>
	<?php endif; ?>

	<?php
		get_template_part( 'auto-generate/templates/sections/gallery' );
	?>
	
	<?php if( isset( $apidata->jsondata->pharalax[1] ) && is_object( $apidata->jsondata->pharalax[1] ) ): ?>
	<div id="parallax" style="background-image: url(<?php echo custom_url_encoder($apidata->jsondata->pharalax[1]->path); ?>);"></div>
	<?php endif; ?>

	<?php
		get_template_part( 'auto-generate/templates/sections/info-links' );
	?>
	<?php
		get_template_part( 'auto-generate/templates/sections/section-7' );
	?>

	<?php endif; ?>


	<?php if( !$apidata->ispaid ): ?>
		<?php
			get_template_part( 'auto-generate/templates/sections/section-7-unpaid' );
		?>
	<?php endif; ?>


	</div>
</div>

<?php if( $apidata->ispaid ): ?>

<div id="dev-template-v3" class="bottom-modal">
	<?php
		get_template_part( 'auto-generate/templates/sections/modal' );
	?>
</div>

<?php endif; ?>

<?php
	get_template_part( 'auto-generate/templates/components/floating-icon' );
?>

<?php if(count($apidata->servicespageslists)): ?>
<?php
	get_template_part( 'auto-generate/templates/servicespages' );
?>
<?php endif; ?>


<?php if(!$apidata->membership_tb_hide_form || !$apidata->membership_tb_hide_services): 
$counterAllowedFloat = [
	!$apidata->membership_tb_hide_form,
	count($apidata->servicespageslists) && !$apidata->membership_tb_hide_services
];	
?>
<div class="custom-floating-side-tab counter-<?php echo count(array_filter($counterAllowedFloat)); ?>">
	<?php if(!$apidata->membership_tb_hide_form): ?>
    <a href="javascript:void(0)" class="has-custom-modal hidden" data-modal-popup="atf-form">GET A QUOTE</a>
	<?php endif; ?>
	<?php if(count($apidata->servicespageslists) && !$apidata->membership_tb_hide_services): ?>
    <a href="javascript:void(0)" class="has-custom-modal hidden" data-modal-popup="our-services">OUR SERVICES</a>
	<?php endif; ?>
</div>
<?php endif; ?>

<?php

get_footer();