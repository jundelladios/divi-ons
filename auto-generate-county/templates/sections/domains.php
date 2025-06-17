<?php 
global $countySettings, $customerData; 
$hascountiespage = (isset($countySettings->jsondata->countiespages) && is_array($countySettings->jsondata->countiespages) && count($countySettings->jsondata->countiespages));
$hascountydomainlinkscontent = (isset($countySettings->jsondata->domainlinkscontent));
?>

<?php if($hascountiespage || $hascountydomainlinkscontent): ?>

<div class="nf nf-container custon-6-section">

    <?php if($hascountydomainlinkscontent): ?>
    <div class="nf-section-2 pb-50">
        <div class="nf-section-2-content">
            <div class="nf-section-2-title">
                <?php echo _ssgen_content($countySettings->jsondata->domainlinkscontent); ?>     
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if($hascountiespage): ?>
    <div class="custom-6-row logo-domains-grid">
        <?php foreach($countySettings->jsondata->countiespages as $domain): ?>
        <?php 
            $domainLink = isset($domain->link) ? $domain->link: '#';
        ?>
        <div>
            <?php if($domain->path): ?>
                <img 
                src="<?php echo $domain->path; ?>"
                width="<?php echo $domain->width; ?>"
                height="<?php echo $domain->height; ?>"
                alt="<?php echo _ssgen_content($domain->alt); ?>"
                >
            <?php endif; ?>
            <a 
            href="<?php echo _ssgen_content($domainLink); ?>" 
            <?php echo !isset($domain->isnewtab) || !$domain->isnewtab ? '' : 'target="_blank"'; ?>
            class="cbtn nf-1-button"><?php echo _ssgen_content($domain->button); ?></a>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

</div>

<?php endif; ?>


<?php 

$freelistingKey = "Free-Listing";

$freelistinglistsdata = array_filter($customerData, function($cs) use($freelistingKey) {
    return ($cs->membership == $freelistingKey);
});

if(count($freelistinglistsdata)):
echo customerMembersHtmlData(['membership' => $freelistingKey]);
endif;

?>
