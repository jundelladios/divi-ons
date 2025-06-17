<?php 
global $remoteURL, $request, $apidata, $directoryURI, $parent, $themeVersion;

$socialMediaListsIcons = [
    'facebook' => "&#xe093;",
    'youtube' => "&#xe0a3;",
    'google' => "&#xe096;",
    'pinterest' => "&#xe095;",
    'twitter' => "&#xe094;",
    'linkedin' => "&#xe09d;",
    'instagram' => "&#xe09a;"
];

$iconpackage = carbon_get_theme_option('ponds_icon_package');

?>
<div class="header-main-container">

    <?php if(!$apidata->membership_tb_hide_contact_infos || !$apidata->membership_tb_hide_directions || !$apidata->membership_tb_hide_form): ?>

    <?php if( $apidata->ispaid ): ?>
    <div class="header-cta-container">
        <div class="m-w-1600 middle-center">
            <div id="cta-header-container" class="grid grid-template-5 mobile-grid-template-3 header-mobile-below-600 hide-phone">                
                
                 <?php if( isset( $apidata->jsondata->socialmedia ) && is_array( $apidata->jsondata->socialmedia ) ): ?>
                <div class="header-column-container hide-phone">
                  <div id="desktop-icons-container" class="w-max-cont middle-center ">

                    <?php foreach($apidata->jsondata->socialmedia as $key => $socicon): ?>
                        <?php if(isset( $socicon->link )): ?>
                            <a href="<?php echo $socicon->link; ?>" target="_blank" <?php echo $socicon->attributes; ?> class="header-link" data-icon="<?php echo $socicon->type; ?>">
                            <?php if(isset( $socialMediaListsIcons[$socicon->type] )): ?>
                                <?php if($iconpackage=="et"): ?>
                                    <span aria-hidden="true" class="et-pb-icon set-social-icon p-10 soc-header"><?php echo $socialMediaListsIcons[$socicon->type]; ?></span>
                                <?php else: ?>
                                    <span aria-hidden="true" class="set-social-icon p-10 soc-header fa fa-brands fa-<?php echo $socicon->type; ?>"></span>
                                <?php endif; ?>
                            <?php else: ?>
                                <img src="<?php echo $socicon->icon; ?>" 
                                alt="<?php echo $socicon->type; ?>" 
                                width="30" height="30"
                                class=" no-lazy"
                                />
                            <?php endif; ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>

                  </div>
                </div>
                <?php endif; ?>

                <?php if( isset( $apidata->jsondata->showDirectionButton ) && $apidata->jsondata->showDirectionButton && !$apidata->membership_tb_hide_directions ): ?>
                <div id="header-directions" class="header-column-container">
                  <a 
                  class="template-button upper-case middle-center btn"
                  href="https://www.google.com/maps/search/<?php echo $apidata->lat; ?>,<?php echo $apidata->lng; ?>"
                  target="_blank"
                  >
                  <?php if($iconpackage=="et"): ?>
                  <span aria-hidden="true" class="icon_pin adjust et-pb-icon">&#xe01c;</span>
                  <?php else: ?>
                    <span aria-hidden="true" class="icon_pin adjust fa fa-compass"></span>
                  <?php endif; ?>
                  <span class="hide-phone"> Get Directions</span></a>
                </div>
                <?php endif; ?>
                
                <?php if( isset( $apidata->phone ) && !empty($apidata->phone) && !$apidata->membership_tb_hide_contact_infos): ?>
                <div id="header-phone" class="header-column-container">
                  <a 
                  class="template-button upper-case middle-center fix-mobile btn"
                  href="<?php echo apply_filters("ons_phone_format_filter_link", $apidata->phone); ?>"
                  >
                  <?php if($iconpackage=="et"): ?>
                    <span aria-hidden="true" class="icon_phone adjust et-pb-icon">&#xe090;</span>
                  <?php else: ?>
                    <span aria-hidden="true" class="icon_phone adjust fa fa-phone"></span>
                  <?php endif; ?>
                  <span class="hide-m"><span class="hide-phone"> <?php echo $apidata->phone; ?></span></span></a>
                </div>
                <?php endif; ?>
                
                <?php if(!$apidata->membership_tb_hide_form): ?>
				<div id="header-get-quote" class="header-column-container">
					<a 
                    class="header-get-a-quote atf-form-open template-button upper-case middle-center fix-mobile btn has-custom-modal hidden" 
                    data-modal-popup="atf-form"
                    href="javascript:void(0)"><span><span>Get a Quote</span></span></a>
				</div>
                <?php endif; ?>

                <?php if( isset( $apidata->jsondata->servicesContent ) && !empty($apidata->jsondata->servicesContent) && $apidata->jsondata->servicesContent != "<p></p>" ): ?>
				<!-- <div id="header-services" class="header-column-container">
					<a class="header-services template-button upper-case middle-center fix-mobile btn" href="javascript:void(0)"><span><span>Services</span></span></a>
				</div> -->
                <?php endif; ?>

            </div>
        </div>
    </div>
    
    <?php else: ?>
        <div class="header-cta-container"></div>
    <?php endif; ?>

    <?php endif; ?>
    

    <div class="header-template-container template-container relative">      
        <div id="navigation-container">
            <!-- Template Menu Logo Wrap  -->
            <div class="template-menu-logo-wrap h-full flex">
                <!-- Template Container -->
                <div class="template-container">
                    <?php $bglogowrap = null; if( isset( $apidata->jsondata->logobg ) && !empty($apidata->jsondata->logobg) ) { $bglogowrap = $apidata->jsondata->logobg; } ?>
                    <div class="main-logowrap" 
                        <?php if( $bglogowrap ) { echo 'style="background: '.$bglogowrap.';"'; } ?>
                    >
                    <a href="<?php echo get_permalink(); ?>">
                        <?php if( $apidata->image ): ?>
                            <?php if( is_object($apidata->image) ): ?>
                                <img 
                                width="<?php echo $apidata->image->width; ?>" 
                                height="<?php echo $apidata->image->height; ?>" 
                                src="<?php echo $apidata->image->path; ?>" 
                                alt="<?php echo $apidata->image->alt; ?>"
                                class="logo-max-height no-lazy"
                                >
                            <?php else: ?>
                                <img 
                                width="auto" 
                                height="auto" 
                                src="<?php echo $apidata->image; ?>" 
                                alt="<?php echo $apidata->name; ?>"
                                class="logo-max-height no-lazy"
                                >
                            <?php endif; ?>
                        <?php endif; ?>
                    </a>
                            </div>
                </div>
                <!-- Template Container Closing -->
                <!-- Header Company Detail -->
                <div id="header-company-details">
					<div class="company-title">
						<h1>
							<?php echo $apidata->name; ?>
						</h1>
					</div>
                    
                    <?php if( isset( $apidata->jsondata->titleContent ) && !empty($apidata->jsondata->titleContent) ): ?>
					<div class="company-sevices-details">
						<?php echo $apidata->jsondata->titleContent; ?>
					</div>
                    <?php endif; ?>

				</div>
                
                </div>
                <!-- Navigation Links Mobile Closing -->
            <!-- Template Menu Logo Wrap Closing -->
        </div>
    </div>
</div>