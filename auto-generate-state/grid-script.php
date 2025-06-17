<?php global $theState, $gridChunk, $thedummygrid, $gridModulo, $gridPreloaders; ?>

<div class="popuplocation no-cookie">
    <div class="content-location">
        <div class="popuplocation-content-wrap">

            <a class="popupgeolocationclose" href="#closepopuplocation" popup-location-close>&times;</a>

            <h4 class="pftitle">Set your location</h4>

            <form id="locationStoreCookie" class="loaded">
                <div class="pffield">
                    <select class="pffieldinput" id="stateListsPopupLocation" placeholder="Select State" style="text-transform:capitalize;" >
                        <?php  
                            // Read the JSON file 
                            $jsondata = file_get_contents(get_stylesheet_directory_uri() . '/states.json');
                            // Decode the JSON file
                            $statedata = json_decode($jsondata,true);
                        ?>
                    
                        <?php foreach($statedata['states'] as $st): ?>
                            <option value="<?php echo $st['state']; ?>"><?php echo $st['state']; ?></option>
                        <?php endforeach; ?>
                    </select>

                </div>

                <div class="pffield">
                    <input class="pffieldinput" id="stateZipPopupLocation" type="text" placeholder="Enter Zip Code"/>
                </div>

                <div class="pffield">
                    <input type="submit" id="btnPopupLocation" value="Set Location" data-text="Set Location" class="cbtn nf-1-button" style="border:0;" />
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function($) {

        var customersApiURL = `<?php echo carbon_get_theme_option('portal_admin') . '/api/v1/customer?'; ?>`;

        function sliceIntoChunks(arr, chunkSize) {
            const res = [];
            for (let i = 0; i < arr.length; i += chunkSize) {
                const chunk = arr.slice(i, i + chunkSize);
                res.push(chunk);
            }
            return res;
        }

        function customerTemplate(cs) {
            var html = ``;
            html += `<div class="customer-grid items">`;
                html += `<div>`;

                    // cs grid header
                    html += `<div class="csgridheader">`;
                    html += `<h3 class="csgridtitle">${cs.name}</h3>`;
                    if(cs.jsondata.altaddress) {
                        html += `<p>${cs.jsondata.altaddress}</p>`;
                    } else {
                        if(cs.address && cs.jsondata.showAddress) {
                            html += `<p>${cs.address}</p>`;
                        }
                        html += `<p>${cs.city?cs.city:''}${cs.servicestates?', '+cs.servicestates:''}${cs.postalcode?' '+cs.postalcode:''}</p>`;
                    }
                    if(cs.ispaid) {
                        html += `<p>`;
                            html += `<a href="https://${cs.domain}/${cs.slug}/#contact" target="_blank">Contact</a>`;
                            if(cs.phone) {
                                html += `
                                    <span>Or Call</span>
                                    <a href="${ons_phone_format_filter_link(cs.phone)}">${cs.phone}</a>
                                `;
                            }
                        html += `</p>`;
                    } else {
                        html += `<p><a href="<?php echo carbon_get_theme_option( 'ponds_inquiry_url' ); ?>" target="_blank">( Is this your business? )</a></p>`;
                    }
                    html += `</div>`;
                    // end of cs grid header

                    // cs grid button
                    html += `<div class="cs-grid-btn-bottom">`;
                    if(cs.ispaid) {
                        html += `
                            <a href="https://${cs.domain}/${cs.slug}/" target="_blank" class="cbtn nf-1-button"><span class="et-pb-icon">&#xe060;</span> Learn More</a>
                        `;

                        if(cs.jsondata.showDirectionButton!==undefined && cs.jsondata.showDirectionButton && !cs.membership_tb_hide_directions) {
                            html += `
                            <a href="https://www.google.com/maps/search/${cs.lat},${cs.lng}" target="_blank" class="cbtn nf-1-button"><span class="et-pb-icon">&#xe01c;</span> Get Directions</a>
                            `;
                        }
                    }
                    else {
                        html += `<a href="https://${cs.domain}/${cs.slug}/" target="_blank" class="cbtn nf-1-button"><span class="et-pb-icon">&#xe060;</span> Get Listed Here</a>`;
                    }
                    html += `</div>`;
                    // end cs grid button

                html += `</div>`;
            html += `</div>`;
            return html;
        }

        function templateSetters(data) {

            var chunked = sliceIntoChunks(data, <?php echo (int) $gridChunk; ?>);
            var numchunked = chunked.length;
            var autodummyinitcount = data.length;
            var gridmodulo = parseInt(<?php echo $gridModulo; ?>);

            // autodummy
            var autoDummyTemplate = `<?php echo $thedummygrid; ?>`;
            var preloaders = `<?php echo $gridPreloaders; ?>`;

            var autodummy = ``;
            while((autodummyinitcount%gridmodulo)!=0) {
                autodummy += autoDummyTemplate;
                autodummyinitcount++;
            }

            var customers = ``;
            chunked.map((row, index) => {
                var chunkindex = index==0? 'show' : '';
                customers += `<div class="cs-grid-row ${chunkindex}" data-chunk-index="${index}">`;
                customers += `<div class="customers grid-module-wrapper generator-sc">`;
                row.map(customer => {
                    customers += customerTemplate(customer);
                });
                if((index == (numchunked-1))) {
                    customers += autodummy;
                }
                customers += preloaders;

                customers += `</div>`;
                if(index+1!=numchunked) {
                    customers += `
                    <div class="customer-loadmoregrid">
                        <a href="#showmore" data-chunk-next="<?php echo $goldchunkindex; ?>" class="nf-1-button" style="margin: 0 auto;">Show More</a>
                    </div>
                    `;
                }
                customers += `</div>`;
            })

            
            if(chunked.length == 0) {

                customers += `<div class="cs-grid-row show">`;
                customers += `<div class="customers grid-module-wrapper generator-sc">`;
                // auto dummy if empty
                for(var i=0;i<gridmodulo;i++) {
                    customers += autoDummyTemplate;
                }

                // preloders
                customers += preloaders;

                customers += `</div>`;
                customers += `</div>`;

            }

            return customers;
        }

        function loadGrid(elem) {
            elem.children().find('.customer-grid.preloader').removeClass('hide');
            elem.children().find('.customer-grid.items').addClass('hide');
            elem.children().find('.customer-loadmoregrid').hide();
        }

        function unloadGrid(elem) {
            elem.children().find('.customer-grid.preloader').addClass('hide');
            elem.children().find('.customer-grid.items').removeClass('hide');
            elem.children().find('.customer-loadmoregrid').show();
        }

        async function fetchCustomersData(elem, $args, callback) {
            var params = $.param({
                ishidden: 0,
                statejson_state: `<?php echo $theState->abv; ?>`,
                default_coordinate_ip: 1,
                //servicestates: `<?php echo $theState->abv; ?>`,
                orderby: `distance`,
                all: 1,
                ...$args
            });
            var requestAPI = `${customersApiURL}${params}`;

            loadGrid(elem);

            var response = await $.get(requestAPI);
            var html = templateSetters(response);
            elem.html(html);
            unloadGrid(elem);

            return response;

        }

        function btnLoadingAsync(elem, status = true) {
            var text = elem.data('text');
            if(status) {
                elem.text('Getting your Location...');
                elem.prop('disabled', true);
            } else {
                elem.text(text);
                elem.prop('disabled', false);
            }
        }


        async function executeFetchCustomersData(position) {
            var bannerSlickElem = $('.banner-adds-slick-item-solo');
            bannerSlickElem.css({ opacity: 0.2 });

            // bind template to all memberships
            var customersData = [];
            var gridModule = $('.customersgriddata');
            for(var i=0; i<gridModule.length; i++) {
                var elemmodule = $($(gridModule)[i]);
                var members = await fetchCustomersData(elemmodule, {
                    lat: position.latitude,
                    lng: position.longitude,
                    membership: elemmodule.data('membership')
                });
                customersData = [...customersData, ...members];
            }

            // banner setter
            bannerSlickElem.slick('unslick');
            var bannerHtml = ``;
            customersData.filter(row => row.banner_ads.length).map((row,index) => {
                if(Array.isArray(row.banner_ads) && row.banner_ads.length) {
                    row.banner_ads.map((banner, bindex) => {
                        bannerHtml += `
                        <div class="slick-item adaptive-height">
                            <a href="${banner.link}" data-caption="${banner.alt}">
                                <img src="${banner.path}" alt="${banner.alt}" width="${banner.width}" height="${banner.height}">
                            </a>
                        </div>
                        `;
                    });
                }
            });
            bannerSlickElem.html(bannerHtml);
            bannerSlickElem.slick(window.slickoptions);
            bannerSlickElem.css({ opacity: 1 });
        }


        // location parser
        function getAddressComponents(components, type) {    
            // types "street_number", "route", "locality", "country", "postal_code", "administrative_area_level_1"
            for (var key in components) {
                if (components.hasOwnProperty(key)) {            

                    if (type == components[key].types[0]) {
                        return components[key].long_name;
                    }  
                }        
            }
        }


        function getAddressComponentsShort(components, type) {    
            // types "street_number", "route", "locality", "country", "postal_code", "administrative_area_level_1"
            for (var key in components) {
                if (components.hasOwnProperty(key)) {            

                    if (type == components[key].types[0]) {
                        return components[key].short_name.toLowerCase();
                    }  
                }        
            }
        }

        // if ponds-geo cookie does not exists
        if(!Cookies.get('ponds-geo')) {
            $('.popuplocation').removeClass('no-cookie');
            navigator.geolocation.getCurrentPosition(function(position) {
                var locationpos = { lat: position.coords.latitude, lng: position.coords.longitude }
                const geocoder = new google.maps.Geocoder();
                geocoder
                .geocode({ location: locationpos })
                .then((response) => {
                    $('#stateListsPopupLocation').val(getAddressComponents(response.results[0].address_components, 'administrative_area_level_1').toLowerCase());
                    $('#stateZipPopupLocation').val(getAddressComponents(response.results[0].address_components, 'postal_code'));
                })
                .catch((e) => window.alert("Geocoder failed due to: " + e));
            });
        }

        async function userCurrentLocationStoreCookie() {
            var geoapi = '<?php echo carbon_get_theme_option('ponds_map_api'); ?>';
            if(!geoapi) {
                alert('Geocode API Key is invalid.');
            }
            var state = $('#stateListsPopupLocation').val();
            var zip = $('#stateZipPopupLocation').val();

            if(!state && !zip) {
                alert('Please select/enter state and zip.');
                return;
            }
            var params = {
                key: geoapi,
                sensor: false,
                address: state,
                components: `postl_code:${zip}`
            };
            var response = await $.get(`https://maps.googleapis.com/maps/api/geocode/json?${$.param(params)}`);
            if(!response.results[0].geometry.location) {
                alert('Your address location could not be found.')
                return;
            }

            Cookies.set('ponds-geo', JSON.stringify({
                ...response.results[0].geometry.location,
                address: `${state}, ${zip}`,
                state: state,
                zip: zip,
                zipcode: zip,
                state_abv: getAddressComponentsShort(response.results[0].address_components, 'administrative_area_level_1').toLowerCase()
            }));

            const parseCookie = JSON.parse(Cookies.get('ponds-geo'));
            executeFetchCustomersData({
                latitude: parseCookie.lat,
                longitude: parseCookie.lng
            });

            $('[current-location-cookie]').html(`${state}, ${zip}`);
            $('.popuplocation').addClass('no-cookie');
            
            var cookieevt = new window.CustomEvent('CookieLatLngSubmit', {
                detail: parseCookie
            });
            window.dispatchEvent(cookieevt);
        }

        $('body').on('click', '[popup-location-close]', function() {
            $('.popuplocation').addClass('no-cookie');
            return false;
        });

        $('body').on('click', '[popup-location-open]', function() {
            $('.popuplocation').removeClass('no-cookie');
            return false;
        });

        // geolocation header insert
        var cookieAddress = "Select Location";
        if(Cookies.get('ponds-geo')) {
            const parseCookie = JSON.parse(Cookies.get('ponds-geo'));
            if(parseCookie.address) {
                cookieAddress = parseCookie.address;
            }

            if(parseCookie.state) {
                $('#stateListsPopupLocation').val(parseCookie.state.toLowerCase());
            }

            if(parseCookie.zip) {
                $('#stateZipPopupLocation').val(parseCookie.zip);
            }
        }
        var cookieLocationHtml = `
            <div class="custom-geolocation-link">
                <a href="#" popup-location-open current-location-cookie>${cookieAddress}</a>
            </div>
        `;

        jQuery("header .select-location-cookie-desktop-append").append(cookieLocationHtml);
        jQuery("header .select-location-cookie-mobile-append").append(cookieLocationHtml);
        // end of geolocation header

        $('#locationStoreCookie').submit(async function(e) {
            e.preventDefault();
            var btn = $('#btnPopupLocation');
            btn.css({ 'pointer-events': 'none', opacity: 0.5 })
            btn.val('Getting your location...');
            await userCurrentLocationStoreCookie();
            btn.css({ 'pointer-events': 'unset', opacity: 1 })
            btn.val(btn.data('text'));
            return false;
        });



    });

</script>