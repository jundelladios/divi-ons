<?php global $theState, $customerData; ?>

<?php
    get_template_part( 'auto-generate-state/templates/sections/banner-ads' );
?>

<?php if( isset( $theState->settings->jsondata->mapheading ) && !empty( $theState->settings->jsondata->mapheading ) ): ?>
<div class="nf-section-2 pt-50">
    <div class="nf-section-2-content">

        <div class="nf-section-2-title">
            <?php echo _ssgen_content( $theState->settings->jsondata->mapheading ); ?>
        </div>

    </div>
</div>
<?php endif; ?>


<?php 

$goldMemberKey = "Gold Member";

$goldmemberslistsdata = array_filter($customerData, function($cs) use($goldMemberKey) {
    return ($cs->membership == $goldMemberKey);
});

if(count($goldmemberslistsdata)):
echo customerMembersHtmlData(['membership' => $goldMemberKey]);
endif;

?>


<div class="nf nf-container nf-section-2 pt-0" style="padding-bottom: 20px;">
    <div class="nf-section-2">
        <div class="nf-section-2-content">
            <div class="nf-section-2-title">
                <h5>Click a Map Dot for More Info or scroll down for Detailed company information</h5>
            </div>
        </div>
    </div>
</div>


<div class="nf nf-container" style="padding-top: 0;">
<?php
    get_template_part( 'auto-generate-state/templates/sections/map' );
?>
</div>

<?php echo customerMembersHtmlData(['membership' => 'Regular Member']); ?>