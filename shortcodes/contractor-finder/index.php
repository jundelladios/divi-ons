<?php 
global $wp; 

$scargs = shortcode_atts( array(
    'result_text' => '[total] Results Near [zipcode]',
    'content' => 'Many contractors/businesses work throughout broad geographies. Please adjust your search radius accordingly and reach out to a contractor/business near you for more information.',
    'zipcode_label' => 'zip code',
    'unit_label' => 'unit',
    'radius_label' => 'search radius',
    'services_label' => 'services',
    'show_map' => 1,
    'show_services' => 1,
    'open_filter' => 1,
    'show_map_label' => 'show map',
    'show_services_label' => 'show services pages',
    'result_title' => 'contractors',
    'request_quote_text' => 'request a quote from ons',
    'request_quote_url' => carbon_get_theme_option( 'ponds_inquiry_url' ),
    'cookie_name' => 'ponds-geo',
    'sticky_top' => 100,
    'services_column' => 5,
    'maptype' => 'roadmap',
    'mapheight' => '500px',
    'pincolor' => '#024B79',
    'domainconfigs' => [],
    'container_size' => '1600px',
    'exclude_service_ids' => '',
    'apply_filter_text' => 'Apply Filter',
    'clear_filter_text' => 'Clear Filter'
  ), $args );

$domainprotocols = array( 'http://', 'https://', 'http://www.', 'https://www.', 'www.' );
$wpdomain = str_replace( $domainprotocols, '', site_url() );

$excludeservicesids = explode(',', $scargs['exclude_service_ids']);
$locatortagsparams = [
    'all' => 1,
    'orderby' => 'priority ASC'
];
$remotelocatortags = carbon_get_theme_option('portal_admin') . '/api/v1/locator-tags?' . http_build_query($locatortagsparams);
$locatortagsapi = wp_remote_get($remotelocatortags); 
$loctags = json_decode( wp_remote_retrieve_body( $locatortagsapi ) );
$defaultKeyCode = "[default]";

$unitval = get_query_var('unit');
$radiusval = get_query_var('radius');
$servicesarray = explode(',', get_query_var('sv')); 
if(get_query_var('sv')=="") {
    $servicesarray=[];   
}
// get default of services
if(!count($servicesarray)) {
    foreach($loctags as $lc) {
        if(in_array($wpdomain, $lc->domains)) {
            $servicesarray = [$lc->id];
        }
    }
}

$zipval = trim(get_query_var('zipcode'));
$filterunitslists = explode(PHP_EOL, carbon_get_theme_option('ponds_filter_units'));
$filterradiuslists = explode(PHP_EOL, carbon_get_theme_option('ponds_filter_radius'));
// default unitval
if(!$unitval) {
    foreach($filterunitslists as $funit) {
        $filterunit = trim(str_replace($defaultKeyCode, "", $funit)); 
        if(strpos($funit, $defaultKeyCode) !== false) {
            $unitval = $filterunit;
        }
    }
}
// default radius
if(!$radiusval) {
    foreach($filterradiuslists as $fradius) {
        $filterradius = trim(str_replace($defaultKeyCode, "", $fradius)); 
        if(strpos($fradius, $defaultKeyCode) !== false) {
            $radiusval = $filterradius;
        }
    }
}

$isopenFilter = get_query_var('filter');
$isopenFilter = $isopenFilter=="" ? $scargs['open_filter'] : $isopenFilter;
$themeuri = get_stylesheet_directory_uri();

// check if has geodata from cookies.
$geodata = (array) onds_custom_cookie_parser($scargs['cookie_name']);
if(!$zipval && isset($geodata['zipcode'])) {
    $zipval = $geodata['zipcode'];
}

$customerAPIEndpoint = carbon_get_theme_option('portal_admin') . '/api/v1/customer?';

$customersret = [];
if(isset($geodata['state'])) {
    $customersfetchapiparams = [
        'tagstatesabv' => $geodata['state_abv'], 
        'lat' => $geodata['lat'], 
        'lng' => $geodata['lng'], 
        'unit_distance' => $unitval, 
        'ishidden' => 0, 
        'default_coordinate_ip' => 1,
        'all' => 1,
        'locatortagfilter' => 1,
        'tagids' => join(",",$servicesarray),
        'servicespageslists' => 1,
        'orderby' => 'distance ASC',
        'radius' => $radiusval
    ];

    $customersfetchapi = $customerAPIEndpoint . http_build_query($customersfetchapiparams);
    $customersexecapi = wp_remote_get($customersfetchapi); 
    $customersret = json_decode( wp_remote_retrieve_body( $customersexecapi ) );
}

$customersret = !is_array($customersret) ? [] : $customersret;

$iconpackage = carbon_get_theme_option('ponds_icon_package');


$isServicesShown = get_query_var('showServices');
$isServicesShown = $isServicesShown=="" ? $scargs['show_services'] : $isServicesShown;
$isMapShown = get_query_var('showMap');
$isMapShown = $isMapShown=="" ? $scargs['show_map'] : $isMapShown;
$domainconfigs = $scargs['domainconfigs'];
?>

<div class="ond-cf-filter-container-wrap">

<div class="ond-cf-filter-container">

    <div class="ond-cf-filter-wrap">

    <div class="ond-cf-thecontainer" style="max-width:<?php echo $scargs['container_size']; ?>">
    
    <div class="ond-cf-desktop">


        <form method="GET" class="ond-cf-filter-form">

        <div class="ond-cf-header-wrap <?php echo $isopenFilter ? "open" : ""; ?>">

            <div class="ond-cf-filter-flex ond-cf-filter-splitter ond-cf-filter-zip ond-cf-uppercase">
                <label class="ond-cf-label" for="ond-cf-zipinput"><?php echo $scargs['zipcode_label']; ?>:</label>
                <input type="text" id="ond-cf-zipinput" class="ond-cf-zipinput ond-cf-realtimezip" name="zipcode" value="<?php echo $zipval; ?>">
            </div>

            <div class="ond-cf-filter-flex ond-cf-filter-splitter ond-cf-filter-unit ond-cf-filter-toggle" ond-cf-accordion-trigger="filter">
                <label class="ond-cf-label ond-cf-title ond-cf-label-header ond-cf-uppercase"><?php echo $scargs['unit_label']; ?></label>
            </div>

            <div class="ond-cf-filter-flex ond-cf-filter-splitter ond-cf-filter-radius ond-cf-filter-toggle" ond-cf-accordion-trigger="filter">
                <label class="ond-cf-label ond-cf-title ond-cf-label-header ond-cf-uppercase"><?php echo $scargs['radius_label']; ?></label>      
            </div>

            <div class="ond-cf-filter-flex ond-cf-filter-splitter ond-cf-filter-services ond-cf-filter-toggle" ond-cf-accordion-trigger="filter">
                <label class="ond-cf-label ond-cf-title ond-cf-label-header ond-cf-uppercase"><?php echo $scargs['services_label']; ?> <span class="ond-cf-services-selected-counter"></span></label>
            </div>

            <div class="ond-cf-filter-flex ond-cf-filter-toggle" ond-cf-accordion-trigger="filter">
                <span class="ond-cf-chevron <?php echo $isopenFilter ? "open" : ""; ?>" ond-cf-accordion-chevron="filter"></span>
            </div>

        </div>



        <div class="ond-cf-filter-body-container <?php echo $isopenFilter ? "accord_open" : ""; ?>" ond-cf-accordion-id="filter" style="display: <?php echo $isopenFilter ? "block" : "none"; ?>;">
            <div class="ond-cf-filter-body">

                <div class="ond-cf-filter-body-zip">
                    <button type="submit" class="ond-cf-btn ond-cf-contractor-buttons ond-cf-filter-btn-main"><?php echo $scargs['apply_filter_text']; ?></button>
                </div>

                <div class="ond-cf-filter-body-unit">
                    <?php 
                        foreach($filterunitslists as $funits): 
                        $filterunit = trim(str_replace($defaultKeyCode, "", $funits)); 
                    ?>
                        <label class="form-check-label small">
                            <input type="radio" name="unit" ond-cf-module="unit" value="<?php echo $filterunit; ?>" <?php echo $unitval == $filterunit ? "checked" : ""; ?>>
                            <span class="ond-cf-uppercase"><?php echo $filterunit; ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>

                <div class="ond-cf-filter-body-radius">
                    <?php 
                        foreach($filterradiuslists as $fradius): 
                        $filterradius = trim(str_replace($defaultKeyCode, "", $fradius)); 
                    ?>
                        <label class="form-check-label small">
                            <input type="radio" name="radius" ond-cf-module="radius" value="<?php echo $filterradius; ?>" <?php echo $radiusval == $filterradius ? "checked" : ""; ?>>
                            <span><?php echo $filterradius; ?></span>
                            <span class="ond-cf-unit-text"><?php echo $unitval; ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>

                <div class="ond-cf-filter-body-services">
                    <?php  
                    foreach($loctags as $fservice): 
                        if(!in_array($fservice->id, $excludeservicesids)):
                    ?>
                        <label class="form-check-label small" style="flex: 0 0 <?php echo 100/$scargs['services_column']; ?>%;">
                            <input type="checkbox" ond-cf-module="services" class="ond-cf-services-checkboxes" name="sv[]" value="<?php echo $fservice->id; ?>" <?php echo in_array( $fservice->id, $servicesarray ) ? "checked" : ""; ?>>
                            <?php if($fservice->tagname): ?>
                            <span><?php echo $fservice->tagname; ?></span>
                            <?php else: ?>
                            <span><?php echo $fservice->tag; ?></span>
                            <?php endif; ?>
                        </label>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </div>

            </div>
        </div>

        </form>

    </div>



    <div class="ond-cf-header-filter-mobile ond-cf-mobile">
        <button class="ond-cf-btn-filtermobile ond-cf-withicon ond-cf-togglepopup">
            <?php if($iconpackage == "et"): ?>
                <span class="ond-cf-icon ond-cf-filter-icon et-pb-icon">&#x67;</span>
            <?php else: ?>
                <i class="ond-cf-icon ond-cf-filter-icon fa fa-sliders"></i>
            <?php endif; ?>
            <span class="ond-cf-btn-filter-title">filter for:
                <span class="ond-cf-btn-ziplabel ond-cf-zip-text"><?php echo $zipval; ?></span>
            </span>
        </button>
    </div>
    
    </div>

    </div>
    

    

    <div class="ond-cf-filter-results-wrap">

    <div class="ond-cf-thecontainer" style="max-width:<?php echo $scargs['container_size']; ?>">
        
        <div class="ond-cf-filter-services-labels ond-cf-filter-flex">
            <!-- auto fetch buttons here -->
        </div>

        <div class="ond-cf-filter-results-heading-content">
            <h4 class="ond-cf-results-title">
                <?php echo $scargs['result_title']; ?>
            </h4>

            <div class="ond-cf-results-content">
                <p class="ond-cf-bold ond-cf-result-total-content" style="display:<?php echo $zipval && count($customersret) ? "block" : "none"; ?>;"><?php 
                    $ondcfcustomertotalresults = count($customersret);
                    echo str_replace(
                        ['[total]', '[zipcode]'], 
                        ['<span class="ond-cf-totalcustomerstext">'.$ondcfcustomertotalresults.'</span>', '<span class="ond-cf-zip-text">'.$zipval.'</span>'],
                        $scargs['result_text']
                    ); 
                ?></p>
                <p><?php echo html_entity_decode($scargs['content']); ?></p>
            </div>
        </div>

        
        <div class="ond-cf-filter-flex ond-cf-resultcheckboxes" style="display: <?php echo $zipval && count($customersret) ? "flex" : "none"; ?>;">
            <label class="form-check-label ond-cf-uppercase">
                <input class="form-checkbox ond-cf-showServices" type="checkbox" value="1" name="showServices" <?php echo $isServicesShown ? "checked": ""; ?>>
                <span><?php echo $scargs['show_services_label']; ?></span>
            </label>

            <label class="form-check-label ond-cf-uppercase">
                <input class="form-checkbox ond-cf-showMap" type="checkbox" value="1" name="showMap" <?php echo $isMapShown ? "checked": ""; ?>>
                <span><?php echo $scargs['show_map_label']; ?></span>
            </label>
        </div>


        <div class="ond-cf-results-loader">
            <!-- loader here -->
            <div class="ond-cf-lds-ripple">
                <div></div>
                <div></div>
            </div>
            <p class="ond-cf-results-loader-status"></p>
        </div>



        <div class="ond-cf-results-lists <?php echo $isMapShown && count($customersret) ? "ond-cf-withmap": ""; ?>">

            <div class="ond-cf-results-lists-map" style="top: <?php echo $scargs['sticky_top']; ?>px;">
                <div id="ondcfmapfilter" style="width:100%;height:<?php echo $scargs['mapheight']; ?>;"></div>
            </div>


            <div class="ond-cf-results-lists-items">

                <?php $customerindexer = 1; ?>
                <?php 
                if(count($customersret)):
                foreach($customersret as $cs):
                    $cs = (array) $cs;
                    $csurl = "https://".$cs['domain']."/".$cs['slug']."/";
                ?>
                <div class="ond-cf-contractor-info" ond-cf-contractor-info="<?php echo $customerindexer; ?>">
                    <div class="ond-cf-contractor-header ond-cf-filter-flex">
                        <div class="ond-cf-contractor-name ond-cf-filter-flex">
                            <span class="ond-cf-article-counter-label ond-cf-filter-flex"><?php echo $customerindexer; ?></span>
                            <?php echo $cs['name']; ?>
                        </div>

                        <div class="ond-cf-contractor-distance ond-cf-uppercase">
                            (<?php echo (int) $cs['distance']; ?> <?php echo $unitval; ?>).
                        </div>
                    </div>
                    <div class="ond-cf-contractor-info-body ond-cf-filter-flex">
                        <div class="ond-cf-contractor-info-body-left ond-cf-filter-flex">
                            <div class="ond-cf-contractor-body-left">
                                <div class="ond-cf-mb20">
                                    
                                    <?php if( !$cs['membership_tb_hide_address'] ): ?>
                                    <?php if( isset($cs['jsondata']->altaddress) ): ?>
										<p class="ond-cf-p0"><?php echo $cs['jsondata']->altaddress; ?></p>
									<?php else: ?>
										<?php if( isset( $cs['address'] ) && $cs['jsondata']->showAddress ): ?>
											<p class="ond-cf-p0"><?php echo $cs['address']; ?></p>
										<?php endif; ?>
										<p class="ond-cf-p0"><?php echo isset( $cs['city'] ) ? $cs['city']: ''; ?><?php echo isset( $cs['servicestates'] ) ? ', '.$cs['servicestates']: ''; ?><?php echo isset( $cs['postalcode'] ) ? ' '.$cs['postalcode']: ''; ?></p>
									<?php endif; ?>	
                                    <?php endif; ?>	

                                </div>

                                <?php if( $cs['ispaid'] ): ?>
                                <div class="ond-cf-mb20">

                                    <?php if(!$cs['membership_tb_hide_contact_form']): ?>
                                    <p class="ond-cf-p0">
                                        <a href="<?php echo $csurl; ?>/#contact" target="_blank">
                                            <?php if($iconpackage == "et"): ?>
                                                <span class="ond-cf-icon et-pb-icon">&#xe076;</span>
                                            <?php else: ?>
                                                <i class="ond-cf-icon fa fa-envelope"></i>
                                            <?php endif; ?>
                                            Contact <?php echo $cs['name']; ?>
                                        </a>
                                    </p>
                                    <?php endif; ?>
                                                
                                    <?php if( isset( $cs['phone'] ) && !$cs['membership_tb_hide_contact_infos'] ): ?>
                                    <p class="ond-cf-p0">
                                        <a href="<?php echo apply_filters("ons_phone_format_filter_link", $cs['phone']); ?>">
                                            <?php if($iconpackage == "et"): ?>
                                                <span class="ond-cf-icon et-pb-icon">&#xe090;</span>
                                            <?php else: ?>
                                                <i class="ond-cf-icon fa fa-phone"></i>
                                            <?php endif; ?>
                                            <?php echo $cs['phone']; ?>
                                        </a>
                                    </p>
                                    <?php endif; ?>

                                </div>
                                <?php endif; ?>

                                <?php if( !$cs['ispaid'] ): ?>
                                <p class="ond-cf-p0"><a href="<?php echo carbon_get_theme_option( 'ponds_inquiry_url' ); ?>" target="_blank">Is this your business?</a></p>
                                <?php endif; ?>

                            </div>
                            <div class="ond-cf-contractor-body-logo">
                                <a href="<?php echo $csurl; ?>" target="_blank">
                                    <?php if( $cs['image'] ): ?>
                                        <?php if( is_object($cs['image']) ): ?>
                                            <img 
                                            width="<?php echo $cs['image']->width; ?>" 
                                            height="<?php echo $cs['image']->height; ?>" 
                                            src="<?php echo $cs['image']->path; ?>" 
                                            alt="<?php echo $cs['image']->alt; ?>"
                                            >
                                        <?php else: ?>
                                            <img 
                                            width="auto" 
                                            height="auto" 
                                            src="<?php echo $cs['image']->image; ?>" 
                                            alt="<?php echo $cs['image']->name; ?>"
                                            >
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </a>
                            </div>
                        </div>

                        <div class="ond-cf-contractor-info-body-bottom-right">
                            <div class="ond-cf-contractor-ctawrap">

                                <?php if( $cs['ispaid'] ): ?>
                                    <a href="<?php echo $csurl; ?>" target="_blank" class="ond-cf-btn ond-cf-contractor-buttons">
                                        <?php if($iconpackage == "et"): ?>
                                            <span class="ond-cf-icon et-pb-icon">&#xe060;</span>
                                        <?php else: ?>
                                            <i class="ond-cf-icon fa fa-info-circle"></i>
                                        <?php endif; ?>
                                        Learn More
                                    </a>

                                    <?php if(isset( $cs['jsondata']->showDirectionButton ) && $cs['jsondata']->showDirectionButton && !$cs['membership_tb_hide_directions']): ?>
                                    <a href="https://www.google.com/maps/search/<?php echo $cs['lat']; ?>,<?php echo $cs['lng']; ?>" target="_blank" class="ond-cf-btn ond-cf-contractor-buttons">
                                        <?php if($iconpackage == "et"): ?>
                                            <span class="ond-cf-icon et-pb-icon">&#xe080;</span>
                                        <?php else: ?>
                                            <i class="ond-cf-icon fa fa-compass"></i>
                                        <?php endif; ?>
                                        Get Directions
                                    </a>
                                    <?php endif; ?>

                                <?php else: ?>
                                    <a href="<?php echo $csurl; ?>" target="_blank" class="ond-cf-btn ond-cf-contractor-buttons">
                                        <?php if($iconpackage == "et"): ?>
                                            <span class="ond-cf-icon et-pb-icon">&#xe080;</span>
                                        <?php else: ?>
                                            <i class="ond-cf-icon fa fa-info-circle"></i>
                                        <?php endif; ?>
                                        Get Listed Here
                                    </a>
                                <?php endif; ?>

                            </div>

                            <div class="ond-cf-contractor-services-pages" style="display: <?php echo $isServicesShown ? "flex": "none"; ?>;">

                                <?php foreach($domainconfigs as $domainkey => $spagesdomain): ?>
                                    <?php 
                                    $filtereddomainspages = array_filter($cs['servicespageslists'], function ($sp) use ($domainkey) {
                                        return ($sp->domain == $domainkey);
                                    });
                                    
                                    if(count($filtereddomainspages) && !$cs['membership_tb_hide_services']):
                                    ?>
                                        <div class="ond-cf-contractor-services-pages-item">
                                            <p class="ond-cf-contractor-spage-title"><?php echo $spagesdomain['services_pages_title']; ?></p>
                                            <ul class="ond-cf-contractor-spage-lists">
                                                <?php foreach($filtereddomainspages as $customerspages): ?>
                                                <li><a href="https://<?php echo $customerspages->domain; ?>/<?php echo $customerspages->slug; ?>/" target="_blank"><?php echo $customerspages->title; ?></a></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php 
                                    endif; 
                                    ?>
                                <?php endforeach; ?>

                            </div>
                        </div>
                    </div>
                </div>
                <?php $customerindexer++; endforeach; endif; ?>


            </div>
        </div>

    </div>

    </div>

</div>

</div>


<?php 
$custminimaldata = [];
if(count($customersret)):
foreach($customersret as $cstret) { $cstret = (array) $cstret;
    $custminimaldata[] = [
        'id' => $cstret['id'],
        'name' => $cstret['name'],
        'lat' => $cstret['lat'],
        'lng' => $cstret['lng']
    ];
}
endif;
?>

<script type="text/javascript">
    var locatortagsscript = <?php echo json_encode($loctags); ?>;
    var ondfiltercookiename = "<?php echo $scargs['cookie_name']; ?>";
    <?php 
    $mapApi = carbon_get_theme_option('ponds_map_api');
    $geocodeapi = "https://maps.googleapis.com/maps/api/geocode/json?key=$mapApi";
    ?>
    var ondgeomapapi = "<?php echo $geocodeapi; ?>";
    var ondiconpackage= "<?php echo $iconpackage; ?>";
    var customermapdata = <?php echo json_encode($custminimaldata); ?>;
    var ondcfmaptype = "<?php echo $scargs['maptype']; ?>";
    var ondmappincolor = "<?php echo $scargs['pincolor']; ?>";
    var ondcftopoffset = <?php echo (int) $scargs['sticky_top']; ?>;
    var ondcfcustomerapiendpoint = "<?php echo $customerAPIEndpoint; ?>";
    var ondcfdomainconfigs = <?php echo json_encode($domainconfigs); ?>;
    var ondcfinquiryurl = "<?php echo carbon_get_theme_option( 'ponds_inquiry_url' ); ?>";
    var ondcfdebounceduration = 2000;
</script>

<?php

add_action('wp_footer', function() use($themeuri, $zipval, $wp, $isopenFilter, $defaultKeyCode, $filterunitslists, $unitval, $filterradiuslists, $radiusval, $loctags, $servicesarray, $scargs, $iconpackage, $excludeservicesids) {
?>
<div class="ond-cf-filter-popup">
    <form class="ond-cf-form-mobile" method="GET">
        <div class="ond-cf-popup-body">
            <h4 class="ond-cf-uppercase ond-cf-bold ond-cf-withicon ond-cf-popup-header">
                <?php if($iconpackage == "et"): ?>
                    <span class="ond-cf-icon ond-cf-filter-icon et-pb-icon">&#x67;</span>
                <?php else: ?>
                    <i class="ond-cf-icon ond-cf-filter-icon fa fa-square-sliders-vertical"></i>
                <?php endif; ?>
                <span class="ond-cf-btn-filter-title">filter for:
                    <span class="ond-cf-btn-ziplabel ond-cf-zip-text"><?php echo $zipval; ?></span>
                </span>
            </h4>

            <button type="button" class="ond-cf-btnclose ond-cf-togglepopup">&times;</button>


            <div class="ond-cf-popup-content-wrap">
                
                <div class="ond-filter-item-wrap">
                    <div class="ond-cf-filter-flex ond-cf-filter-splitter ond-cf-filter-zip ond-cf-uppercase ond-cf-filterzipmobile">
                        <label class="ond-cf-label" for="ond-cf-zipinput"><?php echo $scargs['zipcode_label']; ?>:</label>
                        <input type="text" id="ond-cf-zipinput" class="ond-cf-zipinput ond-cf-realtimezip" name="zipcode" value="<?php echo $zipval; ?>">
                    </div>
                </div>
                    
                <div class="ond-filter-item-wrap">
                    <button type="button" class="ond-cf-filter-toggle ond-cf-accordbtn" ond-cf-accordion-trigger="filterunit">
                        <span><?php echo $scargs['unit_label']; ?></span>
                        <span class="ond-cf-chevron" ond-cf-accordion-chevron="filterunit"></span>
                    </button>

                    <div ond-cf-accordion-id="filterunit" style="display: none;">
                        <div class="ond-cf-filter-body-unit ond-cf-nopadding">
                            <?php 
                                foreach($filterunitslists as $funits): 
                                $filterunit = trim(str_replace($defaultKeyCode, "", $funits)); 
                                if(!$unitval && strpos($funits, $defaultKeyCode) !== false) {
                                    $unitval = $filterunit;
                                }
                            ?>
                                <label class="form-check-label small">
                                    <input type="radio" class="ond-cf-nofetching" ond-cf-module="unit" name="unit" value="<?php echo $filterunit; ?>" <?php echo $unitval == $filterunit ? "checked" : ""; ?>>
                                    <span class="ond-cf-uppercase"><?php echo $filterunit; ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="ond-filter-item-wrap">
                    <button type="button" class="ond-cf-filter-toggle ond-cf-accordbtn" ond-cf-accordion-trigger="filterradius">
                        <span><?php echo $scargs['radius_label']; ?></span>
                        <span class="ond-cf-chevron" ond-cf-accordion-chevron="filterradius"></span>
                    </button>

                    <div ond-cf-accordion-id="filterradius" style="display: none;">
                        <div class="ond-cf-filter-body-radius ond-cf-nopadding">
                            <?php 
                                foreach($filterradiuslists as $fradius): 
                                $filterradius = trim(str_replace($defaultKeyCode, "", $fradius)); 
                                if(!$radiusval) {
                                    $radiusval = strpos($fradius, $defaultKeyCode) !== false ? $filterradius : "";
                                }
                            ?>
                                <label class="form-check-label small">
                                    <input type="radio" class="ond-cf-nofetching" name="radius" ond-cf-module="radius" value="<?php echo $filterradius; ?>" <?php echo $radiusval == $filterradius ? "checked" : ""; ?>>
                                    <span><?php echo $filterradius; ?></span>
                                    <span class="ond-cf-unit-text"><?php echo $unitval; ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>


                <div class="ond-filter-item-wrap">
                    <button type="button" class="ond-cf-filter-toggle ond-cf-accordbtn" ond-cf-accordion-trigger="filterservices">
                        <span><?php echo $scargs['services_label']; ?> <span class="ond-cf-services-selected-counter"></span></span>
                        <span class="ond-cf-chevron <?php echo $isopenFilter ? "open" : ""; ?>" ond-cf-accordion-chevron="filterservices"></span>
                    </button>

                    <div ond-cf-accordion-id="filterservices" style="display: <?php echo $isopenFilter ? "block" : "none"; ?>;">
                        <div class="ond-cf-filter-body-services ond-cf-nopadding ond-cf-servicesmobilefilter">
                            <?php  
                            foreach($loctags as $fservice): 
                            if(!in_array($fservice->id, $excludeservicesids)):
                            ?>
                                <label class="form-check-label small">
                                    <input type="checkbox" ond-cf-module="services" class="ond-cf-services-checkboxes ond-cf-nofetching" name="sv[]" value="<?php echo $fservice->id; ?>" <?php echo in_array( $fservice->id, $servicesarray ) ? "checked" : ""; ?>>
                                    <?php if($fservice->tagname): ?>
                                    <span><?php echo $fservice->tagname; ?></span>
                                    <?php else: ?>
                                    <span><?php echo $fservice->tag; ?></span>
                                    <?php endif; ?>
                                </label>
                            <?php 
                            endif;
                            endforeach; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="ond-cf-popup-footer">
            <button type="button" class="ond-cf-btn ond-cf-clear ond-cf-uppercase"><?php echo $scargs['clear_filter_text']; ?></button>
            <button type="submit" class="ond-cf-btn ond-cf-apply ond-cf-uppercase"><?php echo $scargs['apply_filter_text']; ?></button>
        </div>
    </form>
</div>

<?php
}, 100, 1);