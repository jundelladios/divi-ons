<?php 
global $remoteURL, $request, $apidata, $directoryURI, $parent, $themeVersion;
?>
<div id="atf-slider" class="atf-slider-content overflow-hidden relative">
    <?php if( isset( $apidata->jsondata->background ) && is_array( $apidata->jsondata->background ) && count( $apidata->jsondata->background ) ): ?>
    <div class="atf-slider-content-bg">
        <?php 
        $lzimgIndex = 0; 
        foreach( $apidata->jsondata->background as $bgObj ): ?>
            <?php if( isset($bgObj->path) && is_object($bgObj) ): ?>
                <div> <?php 
                    $ext = pathinfo($bgObj->path, PATHINFO_EXTENSION);
                    $videos = ['mov', 'mp4'];
                    ?>
                    <?php if(in_array($ext, $videos)): ?>
                        <video src="<?php echo $bgObj->path; ?>" autoplay loop playsinline muted></video>
                    <?php else: ?>
                    <img 
                    src="<?php echo $bgObj->path; ?>" 
                    width="<?php echo isset($bgObj->width) ? $bgObj->width : 'auto'; ?>" 
                    height="<?php echo isset($bgObj->height) ? $bgObj->height : 'auto'; ?>" 
                    alt="<?php echo isset($bgObj->alt) ? $bgObj->alt : ''; ?>"
                    class="<?php echo $lzimgIndex == 0 ? 'no-lazy' : ''; ?>"
                    />
                    <?php $lzimgIndex++; endif; ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
    <div id="atf-slider-text-container-section">
        <div class="p-150-0 pb-200 section slider-section p-m-50-0">
                
            <?php if( !$apidata->ispaid ): ?>
                
                <div id="section-4">
                    <div id="contact-info">
                        <div class="unpaid-button-slides">
                            <a class="template-button upper-case middle-center fix-mobile btn" href="<?php echo carbon_get_theme_option( 'ponds_retailer_url' ); ?>" style="margin-top: 30px;">
                                <span aria-hidden="true" class="et-pb-icon ">&#xe01d;</span>
                                <span class="hide-m">More Business Here</span>
                            </a>

                            <a class="template-button upper-case middle-center fix-mobile btn" href="<?php echo carbon_get_theme_option( 'ponds_inquiry_url' ); ?>" target="_blank" style="margin-top: 30px;">
                                <span aria-hidden="true" class="et-pb-icon ">&#x6c;</span>
                                <span class="hide-m">List your Business Here</span>
                            </a>
                        </div>
                    </div>
                </div>

            <?php endif; ?>

        </div>
    </div>
</div>