<?php global $countySettings; ?>
<?php if( isset( $countySettings->jsondata->heading ) && !empty( $countySettings->jsondata->heading ) ): ?>
<div class="nf-section-1">
    <div class="nf-section-1-content">
        <div class="nf-section-1-title">
            <?php echo _ssgen_content( $countySettings->jsondata->heading ); ?>
        </div>
    </div>
</div>
<?php ?>
<?php endif; ?>