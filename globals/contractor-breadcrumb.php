<?php 
global $apidata; $getlocatortag = null; 
foreach($apidata->locatortags as $lctag) {
    if($lctag->state->domain == $apidata->domain) {
        $getlocatortag = $lctag;
    }
}
?>

<div class="page-breadcrumbs nf nf-container" style="padding-top: 0!important; margin-bottom: 50px;">
    <ul>
        <li><a href="<?php echo home_url(); ?>">Home</a></li>
        <li>&rsaquo;</li>
        <li><a href="<?php echo carbon_get_theme_option('ponds_locator_page_url'); ?>"><?php echo carbon_get_theme_option('ponds_locator_text'); ?></a></li>
        <li>&rsaquo;</li>
        <?php if($getlocatortag): ?>
        <li class="text-capitalize"><a href="https://<?php echo $getlocatortag->state->domain; ?>/<?php echo $getlocatortag->state->slug; ?>/"><?php echo $getlocatortag->state->state; ?></a></li>
        <li>&rsaquo;</li>
        <?php endif; ?>
        <li class="text-capitalize"><?php echo $apidata->name; ?></li>
    </ul>
</div>