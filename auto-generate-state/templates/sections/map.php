<?php 
    global $customerData, $customerParams, $theState, $domainconfigs;
    $iterateCustomers = [];

    $customersDataMapLists = array_filter($customerData, function($cs) {
		return !$cs->membership_tb_hide_map_pin;
	});

    foreach($customersDataMapLists as $customer) {
        $iterateCustomers[] = [
            'lat' => $customer->lat,
            'lng' => $customer->lng,
            'id' => $customer->id,
            'ispaid' => $customer->ispaid
        ];
    }

    $iconpackage = carbon_get_theme_option('ponds_icon_package');
?>

<div class="map-module-wrapper generator-sc">



    <div class="themapwrap">

        <div id="customersMap" class="map-module-wrap" style="height: 600px;"></div>

        <div class="map-module-options-wrapper">
            <a href="#center" data-mapgen-loading-btn class="cbtn nf-1-button fitbound" data-text="Fit Bounds">Fit Bounds</a>
        </div>

        <?php foreach($customersDataMapLists as $customer): ?>
        <div class="map-module-content-wrapper" data-customer-id="<?php echo $customer->id; ?>">
            <div class="map-module-content">
                <a href="" class="map-module-close">&times;</a>
                <div class="dnmcontentmapgen">
                    
                        <div>

                            <div class="dnmheader">
                                <div class="dnmimg">
                                    <?php $csimage = isset($customer->image) && isset($customer->image->path) ? $customer->image->path : $customer->image; ?>
                                    <img src="<?php echo $csimage; ?>" />
                                </div>
                                <div class="dnmc">
                                    <h3 class="dnmtitle"><?php echo $customer->name; ?></h3>
                                    <div class="dnmdetails">
                                        <?php if((isset($customer->jsondata->titleContent))): ?>
                                            <?php echo $customer->jsondata->titleContent; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <?php if($customer->ispaid): ?>
                                <div class="btn" style="margin: 20px 0;">
                                    <a href="<?php echo 'https://'.$customer->domain.'/'.$customer->slug; ?>/" target="_blank" class="cbtn nf-1-button">
                                    <?php if($iconpackage=="et"): ?>
                                        <span class="et-pb-icon">&#xe060;</span>
                                    <?php else: ?>
                                        <i class="fa fa-info-circle"></i>
                                    <?php endif; ?> 
                                    Learn More</a>
                                    <?php if( isset( $customer->jsondata->showDirectionButton ) && $customer->jsondata->showDirectionButton && !$customer->membership_tb_hide_directions ): ?>
                                    <a href="https://www.google.com/maps/search/<?php echo $customer->lat; ?>,<?php echo $customer->lng; ?>" target="_blank" class="cbtn nf-1-button">
                                    <?php if($iconpackage=="et"): ?>
											<span class="et-pb-icon">&#xe01c;</span> 
										<?php else: ?>
											<i class="fa fa-compass"></i>
										<?php endif; ?> 
                                    Get Directions</a>
                                    <?php endif; ?>
                                </div>

                                <div style="margin: 20px 0;">

                                   <?php if(isset($customer->phone) && !$customer->membership_tb_hide_contact_infos): ?>
                                        <div><a href="<?php echo apply_filters("ons_phone_format_filter_link", $customer->phone); ?>" class="dnmlink">
                                        <?php if($iconpackage=="et"): ?>
											<span class="et-pb-icon">&#xe00b;</span>
										<?php else: ?>
											<i class="fa fa-phone"></i>
										<?php endif; ?> 
                                         <?php echo $customer->phone ?></a><span style="color: #222;">or</span> <a href="<?php echo 'https://'.$customer->domain.'/'.$customer->slug; ?>/#contact" target="_blank" class="dnmlink">CONTACT</a></div>
                                    <?php endif; ?>

                                    <?php if(isset($customer->website)): ?>
                                        <div><a href="<?php echo $customer->website; ?>" target="_blank" class="dnmlink">
                                        <?php if($iconpackage=="et"): ?>
											<span class="et-pb-icon">&#xe02c;</span>
										<?php else: ?>
											<i class="fa fa-link"></i>
										<?php endif; ?> 
                                         Website</a></div>
                                    <?php endif; ?>
                                    
                                    <?php if(!$customer->membership_tb_hide_contact_infos): ?>
                                    <div><a href="mailto:<?php echo $customer->email; ?>?subject=<?php echo $customer->name; ?>" class="dnmlink">
                                    <?php if($iconpackage=="et"): ?>
                                        <span class="et-pb-icon">&#xe010;</span>
                                    <?php else: ?>
                                        <i class="fa fa-envelope"></i>
                                    <?php endif; ?> 
                                    &nbsp;Email Us</a></div>
                                    <?php endif; ?>

                                    <?php if(!$customer->membership_tb_hide_address): ?>
                                    <?php if(isset($customer->jsondata->altaddress)): ?>
                                        <div>
                                            <a href="https://www.google.com/maps/search/${content.lat},${content.lng}" target="_blank" class="dnmlink">
                                                <?php if($iconpackage=="et"): ?>
                                                    <span class="et-pb-icon">&#xe081;</span> 
                                                <?php else: ?>
                                                    <i class="fa fa-location-dot"></i>
                                                <?php endif; ?>
                                                <?php echo $customer->jsondata->altaddress; ?>
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <div>
                                            <a href="https://www.google.com/maps/search/${content.lat},${content.lng}" target="_blank" class="dnmlink">
                                                <?php if($iconpackage=="et"): ?>
                                                    <span class="et-pb-icon">&#xe081;</span> 
                                                <?php else: ?>
                                                    <i class="fa fa-location-dot"></i>
                                                <?php endif; ?>
                                                
                                                <div>
                                                    <span class="dblock"><?php echo isset($customer->address) && $customer->jsondata->showAddress ? $customer->address : ''; ?></span>
                                                    <span class="dblock">
                                                    <?php echo isset( $customer->city ) ? $customer->city: ''; ?><?php echo isset( $customer->servicestates ) ? ', '.$customer->servicestates: ''; ?><?php echo isset( $customer->postalcode ) ? ' '.$customer->postalcode: ''; ?>
                                                    </span>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    <?php endif; ?>

                                </div>
                                
                                <div class="dnmcontent">
                                    <?php if($customer->jsondata->aboutContent): echo $customer->jsondata->aboutContent; endif; ?>
                                </div>
                            
                            <?php else: ?>
                                
                                <div class="btn" style="margin: 20px 0;">
                                    <a href="<?php echo carbon_get_theme_option( 'ponds_inquiry_url' ); ?>" target="_blank" class="cbtn nf-1-button cblock">
                                    <?php if($iconpackage=="et"): ?>
                                        <span class="et-pb-icon">&#x74;</span>
                                    <?php else: ?>
                                        <i class="fa fa-circle-question"></i>
                                    <?php endif; ?>
                                    Is this your business?</a>

                                    <a href="<?php echo 'https://'.$customer->domain.'/'.$customer->slug; ?>/" target="_blank" class="cbtn nf-1-button cblock">
                                    <?php if($iconpackage=="et"): ?>
                                        <span class="et-pb-icon">&#xe060;</span>
                                    <?php else: ?>
                                        <i class="fa fa-info-circle"></i>
                                    <?php endif; ?>
                                    Get Listed Here</a>
                                </div>

                                <div style="margin: 20px 0;">
                                    <a href="#" class="dnmlink">
                                    <?php if($iconpackage=="et"): ?>
                                        <span class="et-pb-icon">&#xe081;</span> 
                                    <?php else: ?>
                                        <i class="fa fa-location-dot"></i>
                                    <?php endif; ?>
                                    10 Greystone Dr  Nicholasville, Kentucky 40356</a>
                                </div>

                            <?php endif; ?>
                            
                            <?php if(isset($customer->jsondata->servicesPages)): ?>
                            <div class="dnmcontent"><?php echo $customer->jsondata->servicesPages; ?></div>
                            <?php endif; ?>

                            <?php if(!$customer->membership_tb_hide_services): ?>
                            <?php if(count($customer->servicespageslists)): ?>
                                <div style="margin-top: 30px;">
                                    <h4 style="padding-bottom:0;"><strong>Services Pages</strong></h4>
                                    <?php foreach($domainconfigs as $domainkey => $spagesdomain): 
                                        $filtereddomainspages = array_filter($customer->servicespageslists, function ($sp) use ($domainkey) {
                                            return ($sp->domain == $domainkey);
                                        });
                                    ?>

                                        <?php if(count($filtereddomainspages)): ?>
                                            <div style="margin: 20px 0;">
                                                <strong><?php echo $spagesdomain['services_pages_title']; ?></strong>
                                                <?php foreach($filtereddomainspages as $customerspages): ?>
                                                <p style="padding: 0;">
                                                    <a class="dnmlink" href="https://<?php echo $customerspages->domain; ?>/<?php echo $customerspages->slug; ?>/"> 
                                                        <?php echo $customerspages->title; ?>
                                                    </a>
                                                </p>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endif; ?>

                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <?php endif; ?>


                            
                            <!--
                            <hr>

                            <iframe src="https://maps.google.com/maps?q=<?php echo $customer->lat; ?>,<?php echo $customer->lng; ?>&amp;hl=es;z=14&amp;output=embed" width="100%" height="200" style="border:0;" loading="lazy"></iframe>
                            -->

                        </div>

                </div>
            </div>
        </div>
        <?php endforeach; ?>

    </div>

</div>

<script>
    jQuery(document).ready( function($) {
        var mclusterstyle = [
            {
                width: 20,
                height: 20,
                className: "custom-clustericon-1"
            },
            {
                width: 30,
                height: 30,
                className: "custom-clustericon-2"
            },
            {
                width: 40,
                height: 40,
                className: "custom-clustericon-3"
            }
        ];

        // default lat and lng
        var defaultsLatLng = {
            lat: 37.8393332,
            lng: -84.2700179
        }
        if(Cookies.get('ponds-geo')) {
            const parseCookie = JSON.parse(Cookies.get('ponds-geo'));
            defaultsLatLng = {
                lat: parseCookie.lat,
                lng: parseCookie.lng
            };
        }


        var mapDefaultZoom = 8;

        var customersjson = <?php echo is_array($iterateCustomers) ? json_encode($iterateCustomers) : []; ?>;
        var mapOptions = {
            center: new google.maps.LatLng(defaultsLatLng.lat, defaultsLatLng.lng),
            mapTypeId: 'roadmap',
            mapId: "90f87356969d889c",
            streetViewControl: false,
            zoom: mapDefaultZoom
        };

        var markersMap = [];
        var mapCluster = null;
        var mapBounds = null;
        var boundPadding = 200;

        var customersMap = new google.maps.Map(document.getElementById("customersMap"), mapOptions);

        var paidIcon = "<?php echo get_stylesheet_directory_uri() . '/shortcodes/map/src/map-pin-paid.png'; ?>";
        var notPaidIcon = "<?php echo get_stylesheet_directory_uri() . '/shortcodes/map/src/map-pin-unpaid.png'; ?>";

        var bounds = new google.maps.LatLngBounds();
        customersjson.map((row, index) => {
            var latlng = new google.maps.LatLng(row.lat, row.lng);
            var marker = new google.maps.Marker({
                title: row.name,
                position: latlng,
                icon: row.ispaid ? paidIcon : notPaidIcon
            });

            marker.addListener('click', function() {
                $(`.map-module-content-wrapper[data-customer-id="${row.id}"] .map-module-content`).scrollTop(0);
                var mapmodulecontenwrapper = $(`.map-module-content-wrapper[data-customer-id="${row.id}"]`)
                $(`.map-module-content-wrapper`).animate({ left: "-500px" }, 100);
                mapmodulecontenwrapper.animate({ left: 0 }, 100);
            });
            
            markersMap.push(marker);
            bounds.extend(marker.getPosition());
        });

        mapBounds = bounds;
        
        mapCluster = new MarkerClusterer(customersMap, markersMap, {
            styles: mclusterstyle,
            clusterClass: "custom-clustericon",
            zoomOnClick: false,
            gridSize: 32
        });

        function mapZoomHandler() {
            var mapZoom = customersMap.getZoom();
            var refreshZoom = mapZoom > mapDefaultZoom ? mapDefaultZoom : mapZoom;
            customersMap.setZoom(refreshZoom);
        }

        async function setMapCenterOnState() {
            var nolatlngselected = Cookies.get('ponds-geo');
            var geoapi = '<?php echo carbon_get_theme_option('ponds_map_api'); ?>';
            if(geoapi && !nolatlngselected) {
                var params = {
                    key: geoapi,
                    sensor: false,
                    address: "<?php echo $theState->state; ?>"
                };
                var response = await $.get(`https://maps.googleapis.com/maps/api/geocode/json?${$.param(params)}`);
                if(response.results[0].geometry.location) {
                    customersMap.setCenter({
                        ...response.results[0].geometry.location
                    });
                }
            }
        }

        function fitBoundDefault() {
            if(!customersjson.length) {
                setMapCenterOnState();
            } else {
                customersMap.fitBounds(mapBounds, boundPadding)
                google.maps.event.addListenerOnce(customersMap, 'idle', function() {
                    mapZoomHandler();
                });
            }
        }
        fitBoundDefault();

        window.addEventListener("CookieLatLngSubmit", function(evt) {
            if(!customersjson.length) {
                customersMap.setCenter({
                    lat: evt.detail.lat,
                    lng: evt.detail.lng
                });
            }
        }, false);

        google.maps.event.addListener(mapCluster, 'clusterclick', function(cluster){
            customersMap.fitBounds(cluster.getBounds(), boundPadding);
        });

        $('.map-module-wrapper .map-module-close').on('click', function() {
            $('.map-module-content-wrapper').animate({ left: "-500px" }, 100);
            return false;
        });

        $('.map-module-wrapper .fitbound').on('click', function() {
            fitBoundDefault();
            if(!customersjson.length) {
                customersMap.setZoom(mapDefaultZoom);
            }
            return false;
        });

    });
</script>