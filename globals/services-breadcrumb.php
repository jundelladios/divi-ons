<?php 
global $apidata, $servicepage; 
?>

<div class="page-breadcrumbs nf nf-container" style="padding-top: 0!important; margin-bottom: 50px;">
    <ul>
        <li><a href="<?php echo home_url(); ?>">Home</a></li>
        <li>&rsaquo;</li>
        <li><a href="<?php echo carbon_get_theme_option('ponds_locator_page_url'); ?>"><?php echo carbon_get_theme_option('ponds_locator_text'); ?></a></li>
        <li>&rsaquo;</li>
        <?php if($servicepage->related_state): ?>
        <li class="text-capitalize"><a href="https://<?php echo $servicepage->related_state->domain; ?>/<?php echo $servicepage->related_state->slug; ?>/"><?php echo $servicepage->related_state->state; ?></a></li>
        <li>&rsaquo;</li>
        <?php endif; ?>
        <li class="text-capitalize"><a href="https://<?php echo $apidata->domain; ?>/<?php echo $apidata->slug; ?>/"><?php echo $apidata->name; ?></a></li>
        <li>&rsaquo;</li>
        <li class="text-capitalize"><?php echo $servicepage->title; ?></li>
    </ul>
</div>