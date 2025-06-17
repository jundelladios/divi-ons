<?php

if( !function_exists( 'map_generator_module_script' ) ) {
    function map_generator_module_script( $scargs, $mapGenModule, $unid ) {
        ob_start();

        $enableTags = (bool) $scargs['tags'];
        $enableState = (bool) $scargs['state'];

        ?>

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

        jQuery(function($) {

            window.<?php echo $mapGenModule; ?> = {
                mcluster: null,
                loading: false,
                map: null,
                markers: [],
                data: [],
                pagination: {},
                states: [],
                tags: [],
                page: 1,
                uniqid: "<?php echo $unid; ?>",
                api: "<?php echo carbon_get_theme_option('portal_admin') . "/api/v1/customer"; ?>",
                bounds: null,
                lat: <?php echo $scargs['lat']; ?>,
                lng: <?php echo $scargs['lng']; ?>,
                loadingText: 'Loading...',
                inits: {
                    state: '<?php echo $scargs['statevalue']; ?>',
                    tags: '<?php echo $scargs['tags']; ?>'
                },
                _loading: function() {
                    $('[data-mapgen-loading-btn]').text(this.loadingText);

                    $('[data-mapgen-loading], [data-mapgen-loading-btn]').css({
                        'pointer-events': 'none',
                        'opacity': 0.9
                    });
                },
                _finish: function() {
                    $('[data-mapgen-loading-showhide]').show();

                    $.each($('[data-mapgen-loading-btn]'), function() {
                        $(this).text($(this).data('text'));
                    });

                    $('[data-mapgen-loading], [data-mapgen-loading-btn]').css({
                        'pointer-events': 'auto',
                        'opacity': 1
                    });
                },
                getCustomers: async function($args) {
                    this.loading = true;
                    this._loading();
                    var params = $.param({
                        locatortagfilter: 1,
                        page: this.page,
                        limit: <?php echo (int) $scargs['perbatch']; ?>,
                        ishidden: 0,
                        orderby: 'membership.priority DESC, customers.resultpriority DESC',
                        <?php if( $scargs['servicestates'] ): ?>
                        servicestates: '<?php echo $scargs['servicestates']; ?>',
                        <?php endif; ?>
                        ...$args
                    });
                    var result = await $.get(`${this.api}?${params}`);
                    this.page++;
                    this.loading = false;
                    this._finish();
                    return result;
                },
                loadMoreRefresh() {
                    if( !this.pagination.next_page ) {
                        $('.<?php echo $unid; ?> .loadmoredata').hide();
                    } else {
                        $('.<?php echo $unid; ?> .loadmoredata').show();
                    }
                },
                setMarkers: function() {

                    var e = this;
                    var bounds = new google.maps.LatLngBounds();
                    e.markers = [];
                    this.refreshMapCluster();
                    this.data.map((row, i) => {
                        var latlng = new google.maps.LatLng(row.lat, row.lng);
                        var marker = new google.maps.Marker({
                            title: row.name,
                            position: latlng,
                            icon: row.ispaid ? '<?php echo $scargs['piniconpaid'] ?>' : '<?php echo $scargs['piniconunpaid'] ?>'
                        });

                        marker.addListener('click', function() {
                            e.fetchPinClick(i);
                        });
                        
                        e.markers.push(marker);
                        bounds.extend(marker.getPosition());
                    });
                    

                    this.mcluster = new MarkerClusterer(e.map, e.markers, {
                        styles: mclusterstyle,
                        clusterClass: "custom-clustericon"
                    });
                    
                    e.bounds = bounds;
                },
                refreshMapCluster: function() {
                    if( this.mcluster ) {
                        this.mcluster.clearMarkers();
                    }
                },
                centerMapBound: function() {
                    var e = this;
                    var sczoom = <?php echo $scargs['zoom'] ?>;
                    setTimeout(() => {
                        if(!e.data.length) {
                            e.map.setCenter({
                                lat: this.lat,
                                lng: this.lng
                            });
                            e.map.setZoom(sczoom);
                        } else {
                            e.map.fitBounds(e.bounds);
                            var mapZoom = e.map.getZoom();
                            var refreshZoom = mapZoom > sczoom ? sczoom : mapZoom;
                            e.map.setZoom(refreshZoom);
                        }
                    }, 100);
                },
                mapOptions: function() {
                    var sczoom = <?php echo $scargs['zoom'] ?>;
                    return {
                        center: new google.maps.LatLng(this.lat, this.lng),
                        mapTypeId: '<?php echo $scargs['maptype']; ?>' || 'roadmap',
                        mapId: "90f87356969d889c",
                        streetViewControl: false,
                        zoom: sczoom
                    }
                },
                initMap: function() {
                    this.map = new google.maps.Map(document.getElementById("<?php echo $unid; ?>"), this.mapOptions());
                },
                initModule: async function() {
                    this.initMap();

                    var args = {
                        locatorinit: 1
                    };
                    
                    if( this.inits.state ) {
                        args.state = this.inits.state;
                    }

                    await this.loadCustomersInit({ ...args });
                    
                },
                loadCustomersInit: async function($args) {
                    var res = await this.getCustomers({ ...$args });
                    this.data = [...this.data, ...res.customers.data];
                    this.pagination = res.customers.pagination;
                    this.loadMoreRefresh();
                    
                    this.states = res.states.filter(row => row);
                    this.tags = res.tags.filter(row => row);

                    <?php if( $enableTags ): ?>
                    this.setTagsFilter();
                    <?php endif ?>
                    
                    <?php if( $enableState ): ?>
                    this.setStatesFilter();
                    <?php endif ?>

                    this.setMarkers();
                    this.centerMapBound();
                },
                loadCustomersMore: async function($args) {
                    if( this.loading || !this.pagination.next_page ) { return false; }
                    var res = await this.getCustomers({...$args});
                    this.data = [...this.data, ...res.data];
                    this.pagination = res.pagination;
                    this.loadMoreRefresh();
                    this.setMarkers();
                    this.centerMapBound();
                },

                filterCustomers: function() {
                    var vals = $('.<?php echo $unid; ?> .tagsfilters input:checked').map(function() {
                        return $(this).val();
                    }).get().join(',');

                    this.page = 1;
                    this.pagination.next_page = 1;
                    this.data = [];
                    var args = {};
                    if( vals ) { args.tags = vals }


                    var state = $('.<?php echo $unid; ?> .statefilters select').val();
                    if(state) { args.state = state; }

                    this.loadCustomersMore({ ...args });
                },

                <?php if( $enableTags ): ?>
                setTagsFilter() {
                    var html = '';
                    var elem = $('.<?php echo $unid; ?> .tagsfilters');
                    this.tags.map(row => {
                        html += `
                            <label>
                                <input type="checkbox" name="tagfilter[]" value="${row.tag}">
                                ${row.tag}
                            </label>
                        `;
                    });

                    if( !html ) {
                        elem.remove();
                    }

                    $(elem).html(html);
                },
                <?php endif ?>

                <?php if( $enableState ): ?>
                setStatesFilter() {
                    var html = '';

                    html += `<option value="">Please Select...</option>`;

                    var elem = $('.<?php echo $unid; ?> .statefilters select');
                    this.states.map(row => {
                        html += `
                            <option value="${row}">${row}</option>
                        `;
                    });

                    if( !html ) {
                        $('.<?php echo $unid; ?> .statefilters').remove();
                    }

                    elem.html(html);

                    if( this.inits.state ) {
                        elem.val( this.inits.state );
                    }
                },
                <?php endif ?>

                setContentData(index) {

                    var content = this.data[index];

                    console.log(content);

                    var html = '';


                    html += `
                    
                    <div>
                        <div class="dnmheader">
                            <div class="dnmimg">
                                <img src="${content.image && content.image.path ? content.image.path : content.image}" />
                            </div>
                            <div class="dnmc">
                                <h3 class="dnmtitle">${content.name}</h3>
                                <div class="dnmdetails">
                                    ${content.jsondata && content.jsondata.titleContent ? content.jsondata.titleContent : ''}					
                                </div>
                            </div>
                        </div>

                    `

                    if( content.ispaid ) {

                    html += `

                        <div class="btn" style="margin: 20px 0;">
                            <a href="https://${content.domain}/${content.slug}/" target="_blank" class="cbtn nf-1-button"><span class="et-pb-icon">&#xe060;</span> Learn More</a>
                    `;
                    
                    if(cs.jsondata.showDirectionButton!==undefined && cs.jsondata.showDirectionButton && !cs.membership_tb_hide_directions) {
                        html += `
                        <a href="https://www.google.com/maps/search/${content.lat},${content.lng}" target="_blank" class="cbtn nf-1-button"><span class="et-pb-icon">&#xe01c;</span> Get Directions</a>
                        `;
                    }
                            
                    
                    html += `
                        </div>

                        <div style="margin: 20px 0;">
                    `;

                    if( content.phone ) {
                        html += `
                            <div><a href="${ons_phone_format_filter_link(content.phone)}" class="dnmlink"><span class="et-pb-icon">&#xe00b;</span> ${content.phone}</a><span style="color: #222;">or</span> <a href="https://${content.domain}/${content.slug}/#contact" target="_blank" class="dnmlink">CONTACT</a></div>
                        `;
                    }
                    
                    if(content.website) {
                        html += `
                            <div><a href="${content.website}" target="_blank" class="dnmlink"><span class="et-pb-icon">&#xe02c;</span> Website</a></div>
                        `;
                    }

                    html += `
                            <div><a href="mailto:${content.email}?subject=${content.name}" class="dnmlink"><span class="et-pb-icon">&#xe010;</span>&nbsp;Email Us</a></div>
                    `;

                
                    if(content.jsondata.altaddress) {
                        html += `
                            <div><a href="https://www.google.com/maps/search/${content.lat},${content.lng}" target="_blank" class="dnmlink"><span class="et-pb-icon">&#xe081;</span> ${content.jsondata.altaddress}</a></div>
                        `;
                    } else {
                        html += `
                            <div>
                                <a href="https://www.google.com/maps/search/${content.lat},${content.lng}" target="_blank" class="dnmlink">
                                    <span class="et-pb-icon">&#xe081;</span> 
                                    <div>
                                        <span class="dblock">${content.address && content.jsondata.showAddress ? content.address : ''}</span>
                                        <span class="dblock">
                                        ${content.city ? content.city : ''}${content.servicestates ? ', ' + content.servicestates : ''}${content.postalcode ? content.postalcode : ''}
                                        </span>
                                    </div>
                                </a>
                            </div>
                        `;
                    }


                    html += `

                        </div>

                        <div class="dnmcontent">
                            ${content.jsondata && content.jsondata.aboutContent ? content.jsondata.aboutContent : ''}
                        </div>
                    `;

                    } else {

                        html += `

                        <div class="btn" style="margin: 20px 0;">
                            <a href="<?php echo carbon_get_theme_option( 'ponds_inquiry_url' ); ?>" target="_blank" class="cbtn nf-1-button cblock"><span class="et-pb-icon">&#x74;</span> Is this your business?</a>
                            <a href="https://${content.domain}/${content.slug}/" target="_blank" class="cbtn nf-1-button cblock"><span class="et-pb-icon">&#xe060;</span> Get Listed Here</a>
                        </div>

                        <div style="margin: 20px 0;">
                            <a href="#" class="dnmlink"><span class="et-pb-icon">&#xe081;</span> 10 Greystone Dr  Nicholasville, Kentucky 40356</a>
                        </div>

                        `;

                    }


                    if(content.jsondata.servicesPages) {
                        html += `
                        <div class="dnmcontent">${content.jsondata.servicesPages}</div>
                        `;
                    }


                    html += `

                        <hr>

                        <iframe src="https://maps.google.com/maps?q=${content.lat},${content.lng}&amp;hl=es;z=14&amp;output=embed" width="100%" height="200" style="border:0;" loading="lazy"></iframe>

                    </div>   

                    `;


                    $('.dnmcontentmapgen').html(html);

                },

                fetchPinClick(index) {

                    const e = this;

                    $('.<?php echo $unid; ?> .map-module-content').scrollTop(0);

                    var mapmodulecontenwrapper = $('.<?php echo $unid; ?> .map-module-content-wrapper')
                    mapmodulecontenwrapper.animate({
                        left: "-<?php echo $scargs['contentwidth'];  ?>px"
                    }, 100, function() {
                        
                        e.setContentData(index);

                        mapmodulecontenwrapper.animate({
                            left: 0
                        }, 100);

                    });
                }
            };

            $(document).ready( function() {

                google.maps.event.addDomListener(window, "load", <?php echo $mapGenModule; ?>.initModule());

                $('.<?php echo $unid; ?> .map-module-close').on('click', function() {
                    $('.<?php echo $unid; ?> .map-module-content-wrapper').animate({
                        left: "-<?php echo $scargs['contentwidth'];  ?>px"
                    }, 100);
                    return false;
                });

                $('.<?php echo $unid; ?> .loadmoredata').on('click', function() {
                    <?php echo $mapGenModule; ?>.loadCustomersMore();
                    return false;
                });
                
                $('.<?php echo $unid; ?> .fitbound').on('click', function() {
                    <?php echo $mapGenModule; ?>.centerMapBound();
                    return false;
                });

                <?php if( $enableTags ): ?>
                $('.<?php echo $unid; ?> .tagsfilters').delegate('input', 'change', function() {
                    <?php echo $mapGenModule; ?>.filterCustomers();
                });
                <?php endif; ?>

                <?php if( $enableState ): ?>
                $('.<?php echo $unid; ?> .statefilters select').on('change', function() {
                    <?php echo $mapGenModule; ?>.filterCustomers();
                });
                <?php endif; ?>

            });

        });

        <?php
        $html = ob_get_clean();
        return $html;
    }
}
wp_add_inline_script( 'map-generator-cluster', map_generator_module_script( $scargs, $mapGenModule, $unid) );