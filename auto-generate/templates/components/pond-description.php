<?php 
    global $remoteURL, $request, $apidata, $directoryURI, $parent, $themeVersion;
?>

<?php if( isset( $apidata->jsondata->headlineContent ) && !empty($apidata->jsondata->headlineContent) ): ?>
<div id="pond-description" class="float-top">
    <div>
        <div class="title-text-white text-white pond-text-editor-container">
            <div>
                <?php echo $apidata->jsondata->headlineContent; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>