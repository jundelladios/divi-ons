<?php global $theState, $county; ?>
<div class="page-breadcrumbs nf nf-container">
    <ul>
        <li><a href="<?php echo home_url(); ?>">Home</a></li>
        <li>&rsaquo;</li>
        <li><a href="<?php echo carbon_get_theme_option('ponds_locator_page_url'); ?>"><?php echo carbon_get_theme_option('ponds_locator_text'); ?></a></li>
        <li>&rsaquo;</li>
        <li class="text-capitalize"><a href="https://<?php echo $theState->domain; ?>/<?php echo $theState->slug; ?>/"><?php echo $theState->state; ?></a></li>
        <li>&rsaquo;</li>
        <li class="text-capitalize"><?php echo $county->county; ?></li>
    </ul>
</div>