<?php 
    global $remoteURL, $request, $apidata, $directoryURI, $parent, $themeVersion;
?>
<div id="pond-about" class="grid grid-template-7-12">
    <div class="about-left pr-15">
        
        <?php if( isset( $apidata->jsondata->aboutContent ) ): echo $apidata->jsondata->aboutContent; endif; ?>
        <?php if( isset( $apidata->jsondata->aboutURL ) ): ?>
        <div class="mt-15">
            <a href="<?php echo $apidata->jsondata->aboutURL; ?>" id="btn" class="montserrat">Learn More <i class="et-pb-icon">&#x24;</i></a>
        </div>
        <?php endif; ?>
    </div>
    
    <?php 
        
    if( isset( $apidata->jsondata->aboutImages ) && is_array( $apidata->jsondata->aboutImages ) ): 

        $aboutImagesChunked = array_chunk( $apidata->jsondata->aboutImages, 2 );

        if( count( $aboutImagesChunked ) ):

    ?>

    <div class="about-right ml-25">
        <?php $abountchindex=0; foreach( $aboutImagesChunked[0] as $abchunked ): ?>
            <?php if( isset($abchunked->path) && is_object($abchunked) ): ?>
                <div class="<?php if( $abountchindex == 0 ): echo "about-right-top"; elseif( $abountchindex == 1 ): echo "about-right-bottom"; endif; ?>">
                    <img 
                    src="<?php echo $abchunked->path; ?>" 
                    width="<?php echo isset($abchunked->width) ? $abchunked->width : 'auto'; ?>" 
                    height="<?php echo isset($abchunked->height) ? $abchunked->height : 'auto'; ?>"
                    >
                </div>
            <?php endif; ?>
        <?php $abountchindex++; endforeach; ?>
    </div>

    <?php endif; endif; ?>

</div>