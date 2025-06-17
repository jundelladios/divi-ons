<?php 
    global $remoteURL, $request, $apidata, $directoryURI, $parent, $themeVersion;
?>

<div id="section-7" class="relative bg-white">
    <div class="mw-1600 pb-100">
        <div>
            <div id="footer-map-container">
                <div id="footer-left-side">
                    <iframe 
                    src="https://maps.google.com/maps?q=<?php echo $apidata->lat; ?>,<?php echo $apidata->lng; ?>&hl=es;z=14&amp;output=embed" 
                    width="100%" 
                    height="500" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy"></iframe>
                </div>
                <div id="footer-right-side" class="unpaid-footer">

                    <div class="company-title">
                        <h3>
                            <?php echo $apidata->name; ?>
                        </h3>
                    </div>
                    
                    <?php if( isset( $apidata->jsondata->titleContent ) && !empty($apidata->jsondata->titleContent) ): ?>
                    <div class="company-sevices-details">
                        <?php echo $apidata->jsondata->titleContent; ?>
                    </div>
                    <?php endif; ?>


                    <a class="template-button upper-case middle-center fix-mobile btn" href="<?php echo carbon_get_theme_option( 'ponds_inquiry_url' ); ?>" target="_blank" style="margin-top: 30px;">
                        <span aria-hidden="true" class="icon_bag"></span>
                        <span class="hide-m">Claim This Business</span>
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>
