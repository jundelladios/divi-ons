<?php global $theState; ?>
<div class="page-breadcrumbs nf nf-container">
    <ul>
        <li><a href="<?php echo home_url(); ?>">Home</a></li>
        <li>&rsaquo;</li>
        <li><a href="<?php echo carbon_get_theme_option('ponds_locator_page_url'); ?>"><?php echo carbon_get_theme_option('ponds_locator_text'); ?></a></li>
        <li>&rsaquo;</li>
        <li class="text-capitalize"><?php echo $theState->state; ?></li>
    </ul>
</div>