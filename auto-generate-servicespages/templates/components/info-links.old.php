<?php 
    global $remoteURL, $request, $apidata, $directoryURI, $parent, $themeVersion;
?>
<?php if( isset( $apidata->jsondata->infolinks ) && is_array( $apidata->jsondata->infolinks ) && count( $apidata->jsondata->infolinks ) ): ?>
<div id="section-6" class="template-section-8 relative">
    <div id="section-6-container" class="grid grid-template-20-60-20 pt-100 pb-100">
        <div></div>
        <div class="box-white p-50-20 border-r-5">
            <div>
                <h3 class="font-45 text-center"><?php echo $apidata->name; ?></h3>
                <h4 class="font-25 text-center">Informational Links On The Web</h4>
            </div>
            
            <div id="accordion" class="accordion">
                <?php $infolinkIndex = 0; ?>
                <?php foreach( $apidata->jsondata->infolinks as $infolink ): ?>
                    <div class="template-accordion-container <?php echo $infolinkIndex == 0 ? 'open' : ''; ?>">
                        <?php if( isset( $infolink->title ) && !empty( $infolink->title ) ): ?>
                        <div class="template-accordion-title">
                            <h5><?php echo $infolink->title;  ?></h5>
                        </div>
                        <?php endif; ?>

                        <?php if( isset( $infolink->content ) && $infolink->content ): ?>
                            <div class="template-accordion-description" <?php echo $infolinkIndex == 0 ? 'style="display:block;"' : ''; ?>">
                                <?php echo $infolink->content; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php $infolinkIndex++; endforeach; ?>
            </div>

        </div>
        <div class="hide-phone">
            <img loading="lazy" width="259" height="493" src="https://wordpress-583479-2085890.cloudwaysapps.com/wp-content/uploads/2021/10/NicePng_peces-png_4105844.png" alt="" title="NicePng_peces-png_4105844" class="">
        </div>
    </div>
</div>
<?php endif; ?>