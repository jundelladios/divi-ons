<?php 
    global $remoteURL, $request, $apidata, $directoryURI, $parent, $themeVersion;
?>
<div id="contact"></div>
<div id="section-5">
	<div class="title-section">
		<div class="sub-text-primary pond-text-editor-container">
            <?php if( isset( $apidata->jsondata->quickFormContent ) && !empty($apidata->jsondata->quickFormContent) ): ?>
                <?php echo $apidata->jsondata->quickFormContent; ?>
            <?php endif; ?>
        </div>
	</div>
    <div id="section-5-form" class="pt-10">
        <?php
            get_template_part( 'auto-generate/templates/components/quick-form' );
        ?>
    </div>
</div>