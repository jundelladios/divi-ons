<?php 
global $remoteURL, $request, $apidata, $directoryURI, $parent, $themeVersion;
?>
<?php if(!$apidata->membership_tb_hide_form): ?>
<div id="atf-modal" class="atf-modal modal-hidden">
	<div class="close-modal-overlay bg-overlay-black has-custom-modal-close" data-modal-popup="atf-form"></div>
	<div class="atf-sub-container p-50 relative">
		<div class="close-x close-click has-custom-modal-close" data-modal-popup="atf-form">
			<span></span>
			<span></span>
		</div>
		<div class="pond-text-editor-container">
			<div>
				<h3>Quick Contact Form</h3>
				<p>Please tell us about your project and how to contact you. We will call you to discuss within one (1) business day.</p>
			</div>
		</div>
		<div class="h-full">
			<?php
		        get_template_part( 'auto-generate/templates/components/atf-form' );
		    ?>
		</div>
	</div>
</div>
<?php endif; ?>

<?php if( isset( $apidata->jsondata->servicesContent ) && !empty($apidata->jsondata->servicesContent) && $apidata->jsondata->servicesContent != "<p></p>" ): ?>
<div id="header-service-lists" class="modal-hidden">
	<div class="close-click-services overlay-bg">
	</div>	
	<div class="atf-sub-container p-50 relative">
		<div class="close-x close-click-services">
			<span></span>
			<span></span>
		</div>
		<div class="pond-text-editor-container">
			<div class="our-services-title">
				<h3>Our Services</h3>
			</div>
		</div>
		<div class="pond-text-editor-container">
			<div class="our-services-content">
				<?php echo $apidata->jsondata->servicesContent; ?>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>