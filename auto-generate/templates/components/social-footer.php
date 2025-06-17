<?php 
    global $remoteURL, $request, $apidata, $directoryURI, $parent, $themeVersion;
?>

<div id="social-footer">
    <div>
        <div class="sub-text-primary pond-text-editor-container">
            <div>
                <?php if( isset( $apidata->jsondata->footerContent ) && !empty($apidata->jsondata->footerContent) ): ?>
                    <?php echo $apidata->jsondata->footerContent; ?>
                <?php endif; ?>
            </div>
        </div>
        <div id="footer-images" class=" text-center">
            
        <?php if( isset( $apidata->jsondata->socialmedia ) && is_array( $apidata->jsondata->socialmedia ) ): ?>
                <?php
                    $socialMediaLists = [
                        'facebook' => "$directoryURI/auto-generate/img/fb-300x300.png",
                        'youtube' => "$directoryURI/auto-generate/img/utube-300x300.png",
                        'google' => "$directoryURI/auto-generate/img/google-300x300.png",
                        'pinterest' => "$directoryURI/auto-generate/img/pinterest-1-300x300.png",
                        'twitter' => "$directoryURI/auto-generate/img/twitter-1-300x300.png",
                        'linkedin' => "$directoryURI/auto-generate/img/Linkedin-1-300x300.png",
                        'instagram' => "$directoryURI/auto-generate/img/instagram-300x300.png"
                    ];
                ?>
                <?php foreach( $apidata->jsondata->socialmedia as $socm ): ?>
                    <?php if(isset( $socm->link )): ?>
                        <a href="<?php echo $socm->link; ?>" <?php echo $socm->attributes; ?> data-icon="<?php echo $socm->type; ?>">
                            <?php if(isset( $socialMediaLists[$socm->type] )): ?>
                                <img src="<?php echo $socialMediaLists[$socm->type]; ?>" 
                                alt="<?php echo $socm->type; ?>" 
                                width="30" height="30"
                                />
                            <?php else: ?>
                                <img src="<?php echo $socm->icon; ?>" 
                                alt="<?php echo $socm->type; ?>" 
                                width="30" height="30"
                                />
                            <?php endif; ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
</div>