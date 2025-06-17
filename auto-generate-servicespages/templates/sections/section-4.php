<?php 
global $remoteURL, $request, $apidata, $directoryURI, $parent, $themeVersion;
?>
<div 
id="section-4" 
class="pb-100 relative parallax" 
style="
    <?php if( !(isset( $apidata->jsondata->servicesContent ) && !empty($apidata->jsondata->servicesContent) && $apidata->jsondata->servicesContent != "<p></p>") ): ?>
    padding-top: 200px;padding-bottom:200px;
    <?php endif; ?>
    background: var(--template-primary-color);
"
>
    <?php

        ob_start();

        get_template_part( 'auto-generate/templates/components/contact-info' );

        echo apply_filters( 'the_content', ob_get_clean() );
    ?>
</div>