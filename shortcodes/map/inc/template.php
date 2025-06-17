<?php 

$enableTags = (bool) $scargs['tags'];

$enableState = (bool) $scargs['state'];

?>

<div class="<?php echo $unid; ?> map-module-wrapper generator-sc">

    <?php if( $enableTags ): ?>
    <div class="tagsfilters" data-mapgen-loading data-mapgen-loading-showhide></div>
    <?php endif; ?>
    
    <?php if( $enableState ): ?>
    <div class="statefilters" data-mapgen-loading data-mapgen-loading-showhide>
        State <select name="statefilter"></select>
    </div>
    <?php endif; ?>

    <div class="themapwrap">

        <div id="<?php echo $unid; ?>" class="map-module-wrap map-id-<?php echo $unid; ?>" style="height: <?php echo $scargs['height']; ?>px;"></div>

        <div class="map-module-options-wrapper">
            <a href="#loadmore" data-mapgen-loading-btn class="cbtn nf-1-button loadmoredata" data-text="Load More">Load More</a>
            <a href="#center" data-mapgen-loading-btn class="cbtn nf-1-button fitbound" data-text="Fit Bounds">Fit Bounds</a>
        </div>

        <div class="map-module-content-wrapper">
            <div class="map-module-content">
                <a href="" class="map-module-close">&times;</a>
                <div class="dnmcontentmapgen">
                    

                </div>
            </div>
        </div>
    </div>

</div>