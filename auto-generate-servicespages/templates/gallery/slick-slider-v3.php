<?php 
    global $remoteURL, $request, $apidata, $directoryURI, $parent, $themeVersion, $galleryLayout, $galleryColumn, $galleryFancybox;
?>
<div id="slick-slider-v3" class="gallery-container">
    <div class="slick-container" >
        <div class="slider slider-nav slick-item-for-v3 s-c-1-nav">
            <?php foreach( $apidata->gallery as $galdata ): ?>
                <?php if( isset( $galdata->path ) && is_object($galdata) ): ?>
                    <?php 
                        $galwidth = isset($galdata->width) ? (int) $galdata->width : 'auto';
                        $galheight = isset($galdata->height) ? (int) $galdata->height : 'auto';
                        $galtitle = isset($galdata->title) ? $galdata->title : '';
                        $galalt = isset($galdata->alt) ? $galdata->alt : $galtitle;
                    ?>
                    <div class="slick-item">

                        <img 
                            src="<?php echo $galdata->path; ?>" 
                            width="<?php echo $galwidth; ?>" 
                            height="<?php echo $galheight; ?>" 
                            alt="<?php echo $galalt; ?>"
                            <?php if( $galleryFancybox ): ?>
                            href="<?php echo $galdata->path; ?>"
                            data-caption="<?php echo $galalt; ?>"
                            class="slickv3_img_fancy"
                            <?php endif; ?>
                        >

                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>