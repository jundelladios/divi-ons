<?php 
global $theState, $customerData; 
$hasstatepages = (isset($theState->settings->jsondata->statepages) && is_array($theState->settings->jsondata->statepages) && count($theState->settings->jsondata->statepages));
$hasstatedomainlinkscontent = (isset($theState->settings->jsondata->domainlinkscontent));
?>

<?php if($hasstatepages || $hasstatedomainlinkscontent): ?>
<div class="nf nf-container custon-6-section">

    <?php if($hasstatedomainlinkscontent): ?>
    <div class="nf-section-2 pb-50">
        <div class="nf-section-2-content">
            <div class="nf-section-2-title">
                <?php echo _ssgen_content($theState->settings->jsondata->domainlinkscontent); ?>     
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if($hasstatepages): ?>
    <div class="custom-6-row logo-domains-grid">
        <?php foreach($theState->settings->jsondata->statepages as $domain): ?>
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
