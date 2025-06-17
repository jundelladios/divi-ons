<?php 
global $remoteURL, $request, $apidata, $directoryURI, $parent, $themeVersion;
$iconpackage = carbon_get_theme_option('ponds_icon_package');
?>

<?php if( isset( $apidata->phone ) && !empty($apidata->phone) && !$apidata->membership_tb_hide_contact_infos): ?>
<div id="shushu-floating-icon" class="shushu-floating-icon-div">
    <a 
    class="shushu-floating-button"
    href="<?php echo apply_filters("ons_phone_format_filter_link",  $apidata->phone); ?>"
    >
    <?php if($iconpackage=="et"): ?>
        <span aria-hidden="true" class="icon_phone adjust et-pb-icon">&#xe090;</span>
    <?php else: ?>
        <span aria-hidden="true" class="icon_phone adjust fa fa-phone"></span>
    <?php endif; ?> 
    <span class="hide-m"></span></a>
</div>
<?php endif; ?>