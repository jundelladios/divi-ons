<?php 
    global $remoteURL, $request, $apidata, $directoryURI, $parent, $themeVersion, $galleryLayout, $galleryColumn, $galleryFancybox, $servicepage;

    $apidata->gallery = isset($servicepage->jsondata->gallery) ? (array) $servicepage->jsondata->gallery : [];
?>
<div id="gallery-section" class="gallery-section">
    <div class="section-width middle-center">
        
        <?php if( isset( $servicepage->jsondata->galleryDesc ) && !empty($servicepage->jsondata->galleryDesc) ): ?>
        <div id="gallery-text-container">
            <div class="sub-text-primary pond-text-editor-container">
                <?php echo $servicepage->jsondata->galleryDesc; ?>
            </div>
        </div>
        <?php endif; ?>
        

        <?php if( isset($apidata->gallery) && is_array($apidata->gallery) && count($apidata->gallery) ): ?>
        <div class="template-image-content template-gallery">   
            
            <?php if( $galleryLayout == 'mosaic' ): get_template_part( 'auto-generate-servicespages/templates/gallery/mosaic' ); ?>
            
            <?php elseif( $galleryLayout == 'grid' ): get_template_part('auto-generate-servicespages/templates/gallery/fancybox'); ?>
            
            <?php elseif( $galleryLayout == 'gridv2' ): get_template_part('auto-generate-servicespages/templates/gallery/responsive-gallery'); ?>
            
            <?php elseif( $galleryLayout == 'carouselv2' ): get_template_part('auto-generate-servicespages/templates/gallery/slick-slider-v1'); ?>
            
            <?php elseif( $galleryLayout == 'carousel' ): get_template_part('auto-generate-servicespages/templates/gallery/slick-slider-v3'); ?>

            <?php endif; ?>


        </div>
        <?php endif; ?>
        


    </div>
</div>