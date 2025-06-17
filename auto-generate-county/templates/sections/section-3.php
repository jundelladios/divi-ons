<?php global $theState, $county, $countySettings, $counties; ?>
<div class="new-row-feature-below-map">
    <div class="nf-container">
        <div class="new-feature-first-row">
            <div class="nf-content-left-side">
                
                <div class="nf-contents nf-1-title nf-div">
                    <?php if( isset( $countySettings->content ) && !empty( $countySettings->content ) ): ?>
                    <div>
                        <?php echo _ssgen_content( $countySettings->content ); ?>
                        <?php if(isset($county->cities_information) && !empty($county->cities_information)): echo $county->cities_information; endif; ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if( isset( $countySettings->jsondata->listingText ) && !empty( $countySettings->jsondata->listingText ) ): ?>
                    <div>
                        <?php 
                            $thelistingLink = '#'; 
                            if( isset( $countySettings->jsondata->listingURL ) && !empty( $countySettings->jsondata->listingURL ) ) {
                                $thelistingLink = $countySettings->jsondata->listingURL;
                            }
                        ?>
                        <a href="<?php echo $thelistingLink; ?>" class="nf-1-button" style="display: block;">
                            <?php echo $countySettings->jsondata->listingText; ?>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                
                <?php if( isset( $countySettings->jsondata->images ) && is_array( $countySettings->jsondata->images ) && count( $countySettings->jsondata->images ) ): ?>
                <div>
                    <div class="nf-image-container">
                        <?php foreach( $countySettings->jsondata->images as $stateimg ): ?>
                        <div class="nf-image">
                            <a href="<?php echo $stateimg->path; ?>" data-fancybox="images">
                                <img src="<?php echo $stateimg->path; ?>" width="<?php echo $stateimg->width; ?>" height="<?php echo $stateimg->height; ?>" alt="<?php echo $stateimg->alt; ?>">
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>


            </div>
            
            <?php if( isset( $countySettings->jsondata->ads ) && !empty( $countySettings->jsondata->ads ) ): ?>
            <div class="adds-right-side">
                <div>
                    <?php echo _ssgen_content($countySettings->jsondata->ads); ?>
                </div>
            </div>
            <?php endif; ?>

        </div>
        <div>
            <div class="nf-2-title">
                <h3>See other counties:</h3>
            </div>
            <div>
                <div class="nf-accordion">
                    <p class="nf-accordion-title"><?php echo _ssgen_content("County & Town Reference"); ?></p>
                    <div class="nf-accordion-description nf-div">
                        <p>
                            <?php $countiesindex=0; foreach($counties as $cty): ?>
                                <a href="<?php echo 'https://'.$cty->domain.'/'.$cty->slug; ?>/" class="text-capitalize"><?php echo ucwords($cty->county); ?></a><?php if($countiesindex!=count($counties)-1): echo ","; endif; ?>
                            <?php $countiesindex++; endforeach; ?>
                        </p>
                    </div>
                </div>
            </div>
        
        </div>
    </div>
</div>