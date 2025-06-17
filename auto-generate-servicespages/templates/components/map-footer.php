<?php 
    global $remoteURL, $request, $apidata, $directoryURI, $parent, $themeVersion;

    $getFacebookFrame = isset($apidata->jsondata->socialmedia) && is_array($apidata->jsondata->socialmedia) ? array_search( 'facebook', array_column($apidata->jsondata->socialmedia, 'type') ) : false;
    $fbframe = null;
    if(is_int($getFacebookFrame)) {
        $fbframe = $apidata->jsondata->socialmedia[$getFacebookFrame]->link;
    }
?>

<?php ob_start(); ?>
<div class="footermapwrap">
    <div style="border:0;width:100%;height:500px;" id="footermapjs"></div>
    <?php if(!$apidata->membership_tb_hide_address): ?>
    <div class="footermapaddress">
        <?php if(isset($apidata->jsondata->altaddress) && $apidata->jsondata->altaddress): ?>
            <p><?php echo $apidata->jsondata->altaddress; ?></p>
        <?php else: ?>
            <?php if( isset( $apidata->address ) && $apidata->jsondata->showAddress ): ?>
            <p><?php echo $apidata->address; ?></p>
            <?php endif; ?>
            <p><?php echo isset( $apidata->city ) ? $apidata->city: ''; ?><?php echo isset( $apidata->servicestates ) ? ', '.$apidata->servicestates: ''; ?><?php echo isset( $apidata->postalcode ) ? ' '.$apidata->postalcode: ''; ?></p>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>
<?php $footermaphtml = ob_get_clean(); ?>


<?php if( $fbframe ): ?>
<div>
    <div id="footer-map-container">
        <div id="footer-left-side">
            <?php echo $footermaphtml; ?>
        </div>
        <div id="footer-right-side">
            <iframe src="https://www.facebook.com/plugins/page.php?href=<?php echo urlencode($fbframe); ?>&tabs=<?php echo urlencode('timeline, events, messages'); ?>&width=340&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" style="width:100%;" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
        </div>
    </div>
</div>

<?php else: ?>
<div>
    <div id="footer-map-container">
        <?php echo $footermaphtml; ?>
    </div>
</div>

<?php endif; ?>