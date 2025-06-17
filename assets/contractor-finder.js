function ondCFMapOutput() {
  var ondcfMClusterstyle = [
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

  var ondcontractorFinderMapOptions = {
      center: new google.maps.LatLng(37.0902, 95.7129),
      mapTypeId: ondcfmaptype || 'roadmap',
      mapId: "4504f8b37365c3d0",
      zoom: 8
  }

  var ondcontractorFinderMap = new google.maps.Map(document.getElementById("ondcfmapfilter"), ondcontractorFinderMapOptions);
  var condcontractorCluster = null;
  var ondcontractorBound = new google.maps.LatLngBounds();
  var ondcontractorMarkers = [];
  var ondcontractorboundPadding = 50;
  
  customermapdata.map( function(row, index) {
    var latlng = new google.maps.LatLng(row.lat, row.lng);

    var circlemarkericon = {
      path: google.maps.SymbolPath.CIRCLE,
      fillOpacity: 1,
      fillColor: ondmappincolor,
      strokeOpacity: 1,
      strokeWeight: 1,
      strokeColor: ondmappincolor,
      scale: 12
    };

    var marker = new google.maps.Marker({
        title: row.name,
        position: latlng,
        icon: circlemarkericon,
        label: {
          color: '#ffffff', 
          fontSize: '12px', 
          fontWeight: '600',
          text: `${index+1}`
        }
    });

    marker.addListener('click', function() {
      var elem = jQuery(`[ond-cf-contractor-info="${index+1}"]`);
      jQuery('html, body').animate({
          scrollTop: elem.offset().top - ondcftopoffset
      }, 500);
    });

    ondcontractorMarkers.push(marker);
    ondcontractorBound.extend(marker.position);
  });

  condcontractorCluster = new MarkerClusterer(ondcontractorFinderMap, ondcontractorMarkers, {
      styles: ondcfMClusterstyle,
      clusterClass: "custom-clustericon",
      zoomOnClick: false,
      //gridSize: 32
  });


  ondcontractorFinderMap.fitBounds(ondcontractorBound, 200)
  google.maps.event.addListenerOnce(ondcontractorFinderMap, 'idle', function() {
      var mapZoom = ondcontractorFinderMap.getZoom();
      var refreshZoom = mapZoom > 8 ? 8 : mapZoom;
      ondcontractorFinderMap.setZoom(refreshZoom);
  });


  google.maps.event.addListener(condcontractorCluster, 'clusterclick', function(cluster){
      ondcontractorFinderMap.fitBounds(cluster.getBounds(), ondcontractorboundPadding);
  });
}


ondCFMapOutput();

jQuery(document).ready( function($) {

    function debounce(func, wait = 1000, immediate, exec) {
        var timeout;
      
        return function executedFunction() {

          var context = this;
          var args = arguments;

          if(exec) exec.apply(context, args);
              
          var later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
          };
      
          var callNow = immediate && !timeout;
          
          clearTimeout(timeout);
      
          timeout = setTimeout(later, wait);
          
          if (callNow) func.apply(context, args);
        };
    };


    function ondLoading(text = "Loading ...") {
      $('[ond-cf-error-message]').remove();
      $('.ond-cf-btn.labeled-services').css({
        opacity: 0.5,
        'pointer-events': 'none'
      });

      $('.ond-cf-resultcheckboxes, .ond-cf-result-total-content').hide();
      $('.ond-cf-results-loader').show();
      $('.ond-cf-results-loader .ond-cf-results-loader-status').text(text);
    }

    function ondUnloading() {
      $('.ond-cf-btn.labeled-services').css({
        opacity: 1,
        'pointer-events': 'auto'
      });

      $('.ond-cf-results-loader').hide();
    }


    function OndCFgetAddressComponents(components, type) {    
      // types "street_number", "route", "locality", "country", "postal_code", "administrative_area_level_1"
      for (var key in components) {
          if (components.hasOwnProperty(key)) {            

              if (type == components[key].types[0]) {
                  return components[key].short_name;
              }  
          }        
      }
  }


  function OndCFgetAddressComponentsLong(components, type) {    
      // types "street_number", "route", "locality", "country", "postal_code", "administrative_area_level_1"
      for (var key in components) {
          if (components.hasOwnProperty(key)) {            

              if (type == components[key].types[0]) {
                  return components[key].long_name;
              }  
          }        
      }
  }


    async function ondGetStateByZipCookie(zipcode) {
      try {
        var cookie = Cookies.get(ondfiltercookiename);
        if(cookie) {
          cookie = JSON.parse(cookie);
          if(zipcode == cookie.zipcode) {
            return cookie;
          }
        }
        const res = await $.get(`${ondgeomapapi}&address=${zipcode}&components=postl_code:${zipcode}`);
        if(res.results.length) {
          const state_abv = OndCFgetAddressComponents(res.results[0].address_components, 'administrative_area_level_1');
          const state = OndCFgetAddressComponentsLong(res.results[0].address_components, 'administrative_area_level_1');
          const address = `${state}, ${zipcode}`;
          const ordinates = res.results[0].geometry.location;
          
          const data = {
            state: state.toLowerCase(),
            zipcode: zipcode,
            lat: ordinates.lat,
            lng: ordinates.lng,
            state_abv: state_abv.toLowerCase(),
            address: address.toLowerCase(),
            zip: zipcode
          };

          Cookies.set(ondfiltercookiename, JSON.stringify(data));
          return data;
        }
      } catch($e) {
        return null;
      }
    }


    function ondcfBindCustomersAjax(cs, unit, index) {
      var html = ``;
      var csurl = `https://${cs.domain}/${cs.slug}/`;
      var isshowservices = $('[name="showServices"]').prop('checked');
      index = index+1;

      html += `
      <div class="ond-cf-contractor-info" ond-cf-contractor-info="${index}">
      `;

        // header
        html += `
        <div class="ond-cf-contractor-header ond-cf-filter-flex">
        `;
          // title
          html += `
          <div class="ond-cf-contractor-name ond-cf-filter-flex">
          `;
            html += `
              <span class="ond-cf-article-counter-label ond-cf-filter-flex">${index}</span>
              ${cs.name}
            `;
          html += `
          </div>
          `;
          // end title

          // distance with unit
          html += `
          <div class="ond-cf-contractor-distance ond-cf-uppercase">
          `;
            html += `(${parseInt(cs.distance)} ${unit}).`;
          html += `
          </div>
          `;
          // end of distance with unit

        html += `
        </div>
        `;
        // end header



        // info body
        html += `
        <div class="ond-cf-contractor-info-body ond-cf-filter-flex">
        `;
          html += `
          <div class="ond-cf-contractor-info-body-left ond-cf-filter-flex">
          `;
            html += `
            <div class="ond-cf-contractor-body-left">
            `;
              html += `
              <div class="ond-cf-mb20">
              `;

                if(!cs.membership_tb_hide_address) {
                  if(cs.jsondata.altaddress) {
                    html += `
                    <p class="ond-cf-p0">${cs.jsondata.altaddress}</p>
                    `;
                  } else {
                    if(cs.address && cs.jsondata.showAddress) {
                      html += `
                      <p class="ond-cf-p0">${cs.address}</p>
                      `;
                    }
                    html += `
                    <p class="ond-cf-p0">${cs.city?cs.city:''}${cs.servicestates?`, ${cs.servicestates}`:''}${cs.postalcode?` ${cs.postalcode}`:''}</p>
                    `;
                  }
                }


              html += `
              </div>
              `;
              
              if(cs.ispaid) {
                html += `
                <div class="ond-cf-mb20">
                `;

                  if(!cs.membership_tb_hide_contact_form) {
                    html += `
                    <p class="ond-cf-p0">
                    `;
                      html += `
                      <a href="${csurl}/#contact" target="_blank">
                      `;
                        if(ondiconpackage == "et") {
                          html += `<span class="ond-cf-icon et-pb-icon">&#xe076;</span>`;
                        } else {
                          html += `<i class="ond-cf-icon fa fa-envelope"></i>`;
                        }
                        html += `
                        Contact ${cs.name}
                        `;
                      html += `
                      </a>
                      `;
                    html += `
                    </p>
                    `;
                  }

                  if(cs.phone && !cs.membership_tb_hide_contact_infos) {
                    html += `
                    <p class="ond-cf-p0">
                    `;
                      html += `
                      <a href="${ons_phone_format_filter_link(cs.phone)}">
                      `;
                        if(ondiconpackage == "et") {
                          html += `<span class="ond-cf-icon et-pb-icon">&#xe090;</span>`;
                        } else {
                          html += `<i class="ond-cf-icon fa fa-phone"></i>`;
                        }
                        html += cs.phone;
                      html += `
                      </a>
                      `;
                    html += `
                    </p>
                    `;
                  }
                html += `
                </div>
                `;
              }


              if(!cs.ispaid) {
                html += `
                <p class="ond-cf-p0"><a href="${ondcfinquiryurl}" target="_blank">Is this your business?</a></p>
                `;
              }

            html += `
            </div>
            `;

            // logo
            html += `
            <div class="ond-cf-contractor-body-logo">
            `;
              html += `
              <a href="<?php echo $csurl; ?>" target="_blank">
              `;
                if(cs.image) {
                  if(typeof cs.image === 'object') {
                    html += `
                    <img 
                    width="${cs.image.width}" 
                    height="${cs.image.height}" 
                    src="${cs.image.path}" 
                    alt="${cs.image.alt}"
                    />
                    `;
                  } else {
                    html += `
                    <img 
                    width="auto" 
                    height="auto" 
                    src="${cs.image}" 
                    alt="${cs.name}"
                    />
                    `;
                  }
                }
              html += `
              </a>
              `;
            html += `
            </div>
            `;
            // end of logo
          html += `
          </div>
          `;

          
          // start of bottom right
          html += `
          <div class="ond-cf-contractor-info-body-bottom-right">
          `;
            html += `
            <div class="ond-cf-contractor-ctawrap">
            `;
              if(cs.ispaid) {
                html += `
                <a href="${csurl}" target="_blank" class="ond-cf-btn ond-cf-contractor-buttons">
                `;
                  if(ondiconpackage == "et") {
                    html += `<span class="ond-cf-icon et-pb-icon">&#xe060;</span>`;
                  } else {
                    html += `<i class="ond-cf-icon fa fa-info-circle"></i>`;
                  }
                  html += `Learn More`;
                html += `
                </a>
                `;

                if(cs.jsondata.showDirectionButton!==undefined && cs.jsondata.showDirectionButton && !cs.membership_tb_hide_directions) {
                  html += `
                  <a href="https://www.google.com/maps/search/${cs.lat},${cs.lng}" target="_blank" class="ond-cf-btn ond-cf-contractor-buttons">
                  `;
                    if(ondiconpackage == "et") {
                      html += `<span class="ond-cf-icon et-pb-icon">&#xe080;</span>`;
                    } else {
                      html += `<i class="ond-cf-icon fa fa-compass"></i>`;
                    }
                    html += `Get Directions`;
                  html += `
                  </a>
                  `;
                }
              } else {
                html += `
                <a href="${csurl}" target="_blank" class="ond-cf-btn ond-cf-contractor-buttons">
                `;
                  if(ondiconpackage == "et") {
                    html += `<span class="ond-cf-icon et-pb-icon">&#xe060;</span>`;
                  } else {
                    html += `<i class="ond-cf-icon fa fa-info-circle"></i>`;
                  }
                  html += `Get Listed Here`;
                html += `
                </a>`;
              }
            html += `
            </div>
            `;


            // services pages
            html += `
            <div class="ond-cf-contractor-services-pages" style="display: ${isshowservices?"flex":"none"};">
            `;
              for(var dkey in ondcfdomainconfigs) {
                var filtereddomainspages = cs.servicespageslists.filter(x => x.domain == dkey);
                if(filtereddomainspages.length && !cs.membership_tb_hide_services) {
                  html += `
                  <div class="ond-cf-contractor-services-pages-item">
                  `;
                    html += `
                    <p class="ond-cf-contractor-spage-title">${ondcfdomainconfigs[dkey].services_pages_title}</p>
                    `;
                    html += `
                    <ul class="ond-cf-contractor-spage-lists">
                    `;
                      filtereddomainspages.map(spage => {
                        html += `
                        <li><a href="https://${spage.domain}/${spage.slug}/" target="_blank">${spage.title}</a></li>
                        `;
                      });
                    html += `
                    </ul>
                    `;
                  html += `
                  </div>
                  `;
                }
              }
            html += `
            </div>
            `;
              
          html += `
          </div>
          `;
          // end of bottom right

          
        html += `
        </div>
        `;
        // end info body


      html += 
      `</div>`;

      return html;
    }


    async function executeApiRequest() {
      
      var zipcode = $('.ond-cf-zipinput').val();
      var unit = $('[ond-cf-module="unit"]:checked').val();
      var radius = $('[ond-cf-module="radius"]:checked').val();
      var services = $('[ond-cf-module="services"]:checked').map(function() {
        return $(this).val();
      });
      services = [...new Set(services)].join(',');

      if(!zipcode) {
        return false;
      }

      ondLoading(`Searching state for ${zipcode}...`);
      var geodata = await ondGetStateByZipCookie(zipcode);
      if(!geodata) {
        var uiadjust = $('.ond-cf-resultcheckboxes, .ond-cf-result-total-content');
        uiadjust.hide();
        $('.ond-cf-results-lists').hide();
        $('.ond-cf-results-lists-items').html('');
        customermapdata = [];
        ondCFMapOutput();
        ondUnloading();
        return false;
      }

      ondLoading(`Searching contractors...`);
      const customerparams = {
        tagstatesabv: geodata.state_abv,
        lat: geodata.lat,
        lng: geodata.lng,
        unit_distance: unit,
        ishidden: 0,
        default_coordinate_ip: 1,
        all: 1,
        locatortagfilter: 1,
        tagids: services,
        servicespageslists: 1,
        orderby: 'distance ASC',
        radius: radius
      };
      const customers = await $.get(`${ondcfcustomerapiendpoint}${$.param(customerparams)}`);
      $('.ond-cf-totalcustomerstext').text(customers.length);
  
      var htmlbind = ``;
      customers.map(function(row, index) {
        htmlbind += ondcfBindCustomersAjax(row, unit, index);
      });

      // fetch to elem
      $('.ond-cf-results-lists-items').html(htmlbind);

      // refresh map
      customermapdata = customers;
      ondCFMapOutput();

      var uiadjust = $('.ond-cf-resultcheckboxes, .ond-cf-result-total-content');
      if(customers.length) {
        uiadjust.show();
        $('.ond-cf-results-lists').show();
        var url = new URL(window.location.href);
        const showmap = url.searchParams.get('showMap');
        if(showmap==1) {
          $('.ond-cf-results-lists').addClass('ond-cf-withmap');
        } else {
          $('.ond-cf-results-lists').removeClass('ond-cf-withmap');
        }
      } else {
        uiadjust.hide();
        $('.ond-cf-results-lists').removeClass('ond-cf-withmap');
        $('.ond-cf-results-lists').hide();
      }

      ondUnloading();
    }

    function autoSetDataFormChange() {
      
      var zipcode = $('.ond-cf-zipinput').val();
      var unit = $('[ond-cf-module="unit"]:checked').val();
      var radius = $('[ond-cf-module="radius"]:checked').val();
      var checkboxes = $('[ond-cf-module="services"]:checked').map(function() {
        return $(this).val();
      });
      checkboxes = [...new Set(checkboxes)];
      $('.ond-cf-unit-text').text(unit);

      var url = new URL(window.location.href);
      url.searchParams.set('showMap', $('.ond-cf-showMap').prop('checked') ? 1 : 0);
      url.searchParams.set('showServices', $('.ond-cf-showServices').prop('checked') ? 1 : 0);
      url.searchParams.set('zipcode', zipcode);
      url.searchParams.set('unit', unit);
      url.searchParams.set('radius', radius);
      url.searchParams.set('sv', checkboxes.join(','));

      window.history.pushState({}, '', url.href);
    }

    $('.ond-cf-filter-form').submit( function() {
      autoSetDataFormChange();
      executeApiRequest();
      return false;
    });

    // $('.ond-cf-form-mobile').change(function() {
    //   autoSetDataFormChange($(this));
    // });



    $('.ond-cf-form-mobile').submit( function(e) {
      $('.ond-cf-filter-popup').toggleClass('show');
      autoSetDataFormChange();
      executeApiRequest();
      return false;
    });



    $('.ond-cf-filter-toggle').click( function() {
      var triggeraccord = $(this).attr('ond-cf-accordion-trigger');
      $(`[ond-cf-accordion-chevron="${triggeraccord}"]`).toggleClass('open');
      var theaccordion = $(`[ond-cf-accordion-id="${triggeraccord}"]`);
      theaccordion.slideToggle(200,'linear');
      theaccordion.trigger('accordionChange');
      theaccordion.toggleClass('accord_open');
      return false;
    });


    $('.ond-cf-filter-body-container').on('accordionChange', function() {
      var url = new URL(window.location.href);
      var openfilter = $('.ond-cf-filter-body-container').hasClass('accord_open');
      url.searchParams.set('filter', openfilter?0:1);
      window.history.pushState({}, '', url.href);
    });


    $('.ond-cf-togglepopup').click( function() {
      $('.ond-cf-filter-popup').toggleClass('show');
    });

    $('.ond-cf-btn.ond-cf-clear').click( function() {
      $('.ond-cf-services-checkboxes:checked').prop('checked', false);
      servicesSelectedButtons();
      autoSetDataFormChange();
      executeApiRequest();
      return false;
    });


    function servicesSelectedButtons() {
      var checkedServices = $('.ond-cf-services-checkboxes:checked');
      const checkedValues = [];
      var btnstr = ``;

      $.each(checkedServices, function() {
        const curval = $(this).val();
        if ($.inArray(curval, checkedValues) == -1) {
          checkedValues.push(curval);
          const getloctag = locatortagsscript.find(x => x.id == curval);
          const taglabel = getloctag.tagname ? getloctag.tagname : getloctag.tag;
          btnstr += `
            <button class="ond-cf-btn labeled-services ond-cf-filter-flex" ond-cf-data-id="${curval}">
                <span>${taglabel}</span>
                <span class="ond-cf-labeled-services-close">&times;</span>
            </button>
          `;
        }
      });

      $('.ond-cf-filter-services-labels').html(btnstr);
      $('.ond-cf-services-selected-counter').text(checkedValues.length>0?`(${checkedValues.length})`:``);
    }

    // initialize services labeled button and counter
    servicesSelectedButtons();

    // zip code auto change text from input both desktop and mobile
    $('.ond-cf-zipinput').on('input', function() {
      $('.ond-cf-zipinput').val($(this).val());
      $('.ond-cf-zip-text').text($(this).val());
    });


    // sync radio and checkbox both mobile and desktop
    $('[ond-cf-module]').change( debounce( function() {
        // if(!$(this).hasClass('ond-cf-nofetching')) {
        //   executeApiRequest();
        // }
      }, 
      ondcfdebounceduration, 
      false,
      function() {
        var module = $(`[ond-cf-module="${$(this).attr('ond-cf-module')}"][value="${$(this).val()}"]`);
        module.prop('checked', $(this).prop('checked'));
        servicesSelectedButtons();
        //autoSetDataFormChange();
      }
    ));

    // labeled buttons click and uncheck service
    $('.ond-cf-filter-results-wrap').on('click', '[ond-cf-data-id]', function() {
      var chckbox = $(`.ond-cf-services-checkboxes[value="${$(this).attr('ond-cf-data-id')}"]`);
      chckbox.prop('checked', false);
      $(this).remove();
      autoSetDataFormChange();
      executeApiRequest();
      return false;
    });


    $('.ond-cf-showMap').change( function() {
      autoSetDataFormChange();
      if($(this).prop('checked')) {
        $('.ond-cf-results-lists').addClass('ond-cf-withmap');
      } else {
        $('.ond-cf-results-lists').removeClass('ond-cf-withmap');
      }
    });

    $('.ond-cf-showServices').change( function() {
      autoSetDataFormChange();
      if($(this).prop('checked')) {
        $('.ond-cf-contractor-services-pages').slideToggle({ direction: "up" }, 200,'linear');
      } else {
        $('.ond-cf-contractor-services-pages').slideToggle({ direction: "down" }, 200,'linear');
      }
    });


    function execGeoErrorMessage() {
      jQuery('.ond-cf-results-lists-items')
      .html('<p ond-cf-error-message style="color: red;">We can\'t capture your zipcode with your current location, please enter your zipcode manually. <a href="#" ond-cf-error-message-remove>Got it!</a></p>');
    }

    $('.ond-cf-results-lists-items').on('click', '[ond-cf-error-message-remove]', function() {
      $('[ond-cf-error-message]').remove();
      return false;
    });

    // if there is no zipcode and cookie
    if(!Cookies.get(ondfiltercookiename)) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var locationpos = { lat: position.coords.latitude, lng: position.coords.longitude }
            const geocoder = new google.maps.Geocoder();
            geocoder
            .geocode({ location: locationpos })
            .then((response) => {
                var zipcode = OndCFgetAddressComponentsLong(response.results[0].address_components, 'postal_code');
                if(zipcode) {
                  $('.ond-cf-zipinput').val(zipcode);
                  autoSetDataFormChange();
                  executeApiRequest();
                } else {
                  execGeoErrorMessage();
                }
            })
            .catch((e) => {
              execGeoErrorMessage();
            });
        });
    }

});