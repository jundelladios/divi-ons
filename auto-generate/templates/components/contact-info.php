<?php 
global $remoteURL, $request, $apidata, $directoryURI, $parent, $themeVersion;
?>
<?php if( isset( $apidata->jsondata->servicesContent ) && !empty($apidata->jsondata->servicesContent) && $apidata->jsondata->servicesContent != "<p></p>" ): ?>
<div id="contact-info">
    <div>
        <div id="contact-boxes" class="pt-100 no-transform">
            <div class="shushu-page-services">
                <div class="contact-box">
                    <div>
                        <?php echo $apidata->jsondata->servicesContent; ?>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>