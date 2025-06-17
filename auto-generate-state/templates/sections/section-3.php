<?php global $theState; ?>
<div class="new-row-feature-below-map">
    <div class="nf-container">
        <div class="new-feature-first-row">
            <div class="nf-content-left-side">
                
                <div class="nf-contents nf-1-title nf-div">
                    <?php if( isset( $theState->settings->content ) && !empty( $theState->settings->content ) ): ?>
                    <div>
                        <?php echo _ssgen_content( $theState->settings->content ); ?>
                    </div>
                    <?php endif; ?>
                    
                    <?php if( isset( $theState->settings->jsondata->listingText ) && !empty( $theState->settings->jsondata->listingText ) ): ?>
                    <div>
                        <?php 
                            $thelistingLink = '#'; 
                            if( isset( $theState->settings->jsondata->listingURL ) && !empty( $theState->settings->jsondata->listingURL ) ) {
                                $thelistingLink = $theState->settings->jsondata->listingURL;
                            }
                        ?>
                        <a href="<?php echo $thelistingLink; ?>" class="nf-1-button" style="display: block;">
                            <?php echo $theState->settings->jsondata->listingText; ?>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                
                <?php if( isset( $theState->settings->jsondata->images ) && is_array( $theState->settings->jsondata->images ) && count( $theState->settings->jsondata->images ) ): ?>
                <div>
                    <div class="nf-image-container">
                        <?php foreach( $theState->settings->jsondata->images as $stateimg ): ?>
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
            
            <?php if( isset( $theState->settings->jsondata->ads ) && !empty( $theState->settings->jsondata->ads ) ): ?>
            <div class="adds-right-side">
                <div>
                    <?php echo _ssgen_content($theState->settings->jsondata->ads); ?>
                </div>
            </div>
            <?php endif; ?>

        </div>
        <div>
            <div class="nf-2-title">
                <h3><?php echo _ssgen_content("Counties in [state] ([abv])"); ?></h3>
            </div>
            <div>
                <div class="nf-accordion">
                    <p class="nf-accordion-title"><?php echo _ssgen_content("[state] County & Town Reference"); ?></p>
                    <div class="nf-accordion-description nf-div">
                        <p>
                            <?php $countiesindex=0; foreach($theState->counties as $county): ?>
                                <a href="<?php echo 'https://'.$county->domain.'/'.$county->slug; ?>/" class="text-capitalize"><?php echo ucwords($county->county); ?></a><?php if($countiesindex!=count($theState->counties)-1): echo ","; endif; ?>
                            <?php $countiesindex++; endforeach; ?>
                        </p>
                    </div>
                </div>
                <div class="nf-accordion">
                    <p class="nf-accordion-title"><?php echo _ssgen_content("[state] State Information"); ?></p>
                    <div class="nf-accordion-description nf-div">
                        <?php echo $theState->state_information; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>