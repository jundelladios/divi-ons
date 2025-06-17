<?php 
    global $remoteURL, $request, $apidata, $directoryURI, $parent, $themeVersion, $servicepage;
?>

<?php if( isset( $servicepage->jsondata->headlineContent ) && !empty($servicepage->jsondata->headlineContent) ): ?>
<div id="pond-description" class="float-top">
    <div>
        <div class="title-text-white text-white pond-text-editor-container">
            <div>
                <?php echo $servicepage->jsondata->headlineContent; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>