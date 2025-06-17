<?php 
    global $remoteURL, $request, $apidata, $directoryURI, $parent, $themeVersion, $servicepage;
?>
<div id="pond-about" class="grid grid-template-7-12">
    <div class="about-left pr-15">
        
        <?php if( isset( $servicepage->jsondata->aboutContentv2 ) ): echo $servicepage->jsondata->aboutContentv2; endif; ?>
        <?php if( isset( $servicepage->jsondata->aboutURLv2 ) ): ?>
        <div class="mt-15">
            <a href="<?php echo $servicepage->jsondata->aboutURLv2; ?>" id="btn" class="montserrat"><?php echo $servicepage->jsondata->aboutURLTextv2; ?> <i class="et-pb-icon">&#x24;</i></a>
        </div>
        <?php endif; ?>
    </div>
    
    <?php 
        
    if( isset( $servicepage->jsondata->aboutImagesv2 ) && is_array( $servicepage->jsondata->aboutImagesv2 ) ): 

        $aboutImagesChunked = array_chunk( $servicepage->jsondata->aboutImagesv2, 2 );

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