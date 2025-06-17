<?php 
    global $remoteURL, $request, $apidata, $directoryURI, $parent, $themeVersion, $galleryLayout, $galleryColumn, $galleryFancybox;
?>

<div id="responsive-gallery-container" class="gallery-container no-text-overlay">
    <div id="responsive-gallery-description">
        <div class="wrap grid grid-template-<?php echo $galleryColumn; ?> less-600-grid-template-2">

          <?php foreach( $apidata->gallery as $galdata ): ?>
              <?php if( isset( $galdata->path ) && is_object($galdata) ): ?>
                <?php 
                  $galwidth = isset($galdata->width) ? (int) $galdata->width : 'auto';
                  $galheight = isset($galdata->height) ? (int) $galdata->height : 'auto';
                  $galtitle = isset($galdata->title) ? $galdata->title : '';
                  $galalt = isset($galdata->alt) ? $galdata->alt : $galtitle;
                ?>

                <div class="card">
                    <div class="boxInner card-image">
                    <?php if( $galleryFancybox ): ?>
                      <a href="<?php echo $galdata->path; ?>" data-fancybox="gallery" data-caption="<?php echo $galalt; ?>">
                        <img src="<?php echo $galdata->path; ?>" width="<?php echo $galwidth; ?>" height="<?php echo $galheight; ?>" alt="<?php echo $galalt; ?>">
                      </a>
                    <?php else: ?>
                      <img src="<?php echo $galdata->path; ?>" width="<?php echo $galwidth; ?>" height="<?php echo $galheight; ?>" alt="<?php echo $galalt; ?>">
                    <?php endif; ?>
                    </div>
                </div>

              <?php endif; ?>
            <?php endforeach; ?>

        </div>
    </div>
</div>