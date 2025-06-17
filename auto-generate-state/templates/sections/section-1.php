<?php global $theState; ?>
<?php if( isset( $theState->settings->jsondata->heading ) && !empty( $theState->settings->jsondata->heading ) ): ?>
<div class="nf-section-1">
    <div class="nf-section-1-content">
        <div class="nf-section-1-title">
            <?php echo _ssgen_content( $theState->settings->jsondata->heading ); ?>
        </div>
    </div>
</div>
<?php ?>
<?php endif; ?>