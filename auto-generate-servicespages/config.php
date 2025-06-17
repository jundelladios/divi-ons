<?php

$genid = get_post_meta(get_the_ID(), 'generator_id', true);
$gendomain = get_post_meta(get_the_ID(), 'generator_domain', true);

$paramAPI = [
	'id' => $genid,
	'domain' => $gendomain
];
$remoteURL = carbon_get_theme_option('portal_admin') . '/api/v1/services-pages?' . http_build_query($paramAPI);
$request = wp_remote_get($remoteURL); 
$servicepage = json_decode( wp_remote_retrieve_body( $request ) );

$paramAPI = [
	'id' => $servicepage->customer_id,
	'servicespageslists' => 1,
	'locatortags' => 1,
];
$remoteURL = carbon_get_theme_option('portal_admin') . '/api/v1/customer?' . http_build_query($paramAPI);
$request =  wp_remote_get($remoteURL); 
$apidata = json_decode( wp_remote_retrieve_body( $request ) );
$apidata->ispaid = $servicepage->ispaid;

$directoryURI = get_stylesheet_directory_uri();
$parent = wp_get_theme()->parent();
$themeVersion = $parent->Version;
$mapApi = carbon_get_theme_option('ponds_map_api');

$cssAssets = [
	[
		'id' => 'auto-generate',
		'href' => "$directoryURI/auto-generate/style.css?ver=$themeVersion"
	],
	[
		'id' => 'auto-generate-mobile',
		'href' => "$directoryURI/auto-generate/style-mobile.css?ver=$themeVersion"
	],
	// [
	// 	'id' => 'auto-generate-font',
	// 	'href' => "$directoryURI/auto-generate/font.css?ver=$themeVersion"
	// ],
	[
		'id' => 'auto-generate-slick',
		'href' => "$directoryURI/auto-generate/slick/slick.css?ver=$themeVersion"
	],
	[
		'id' => 'auto-generate-slick-theme',
		'href' => "$directoryURI/auto-generate/slick/slick-theme.css?ver=$themeVersion"
	],
	[
		'id' => 'auto-generate-fancybox',
		'href' => "$directoryURI/auto-generate/fancybox.css?ver=$themeVersion"
	]
];

$jsAssets = [
	[
		'id' => 'auto-generate-slick',
		'href' => "$directoryURI/auto-generate/slick/slick.min.js?ver=$themeVersion"
	],
	[
		'id' => 'auto-generate-fancybox',
		'href' => "$directoryURI/auto-generate/fancybox.js?ver=$themeVersion"
	],
	[
		'id' => 'auto-generate',
		'href' => "$directoryURI/auto-generate/script.js?ver=$themeVersion"
	],
	[
		'id' => 'auto-generate-inputmask',
		'href' => "$directoryURI/assets/input-mask.js?ver=$themeVersion"
	],
	[
		'id' => 'auto-generate-gmap',
		'href' => "https://maps.googleapis.com/maps/api/js?key=$mapApi&v=beta&callback=ONSMapInit"
	]
];

$galleryLayout = isset($servicepage->jsondata->galleryLayout) ? $servicepage->jsondata->galleryLayout : "grid";
$galleryColumn = isset($servicepage->jsondata->galleryColumn) ? (int) $servicepage->jsondata->galleryColumn : 3;
$galleryFancybox = isset($servicepage->jsondata->galleryFancyBox) ? (boolean) $servicepage->jsondata->galleryFancyBox : false;

// css assets
foreach( $cssAssets as $csselem ) {
    wp_enqueue_style( $csselem['id'], $csselem['href'] );
}

// js assets
foreach( $jsAssets as $jselem ) {
    wp_enqueue_script( $jselem['id'], $jselem['href'], array( 'jquery' ), $themeVersion, true );
}

// input mask
function autogenInputMask() {
	ob_start();
	?>
	jQuery(document).ready( function($) {
		var inputPhoneMasking = jQuery('[data-mask]');
		inputPhoneMasking.each( function() {
			jQuery(this).inputmask(jQuery(this).data('mask'));
		});
	});
	<?php
	$html = ob_get_clean();
	return $html;
}
wp_add_inline_script( 'auto-generate-inputmask', autogenInputMask() );
// end of input mask

if( !function_exists( 'autogenTemplateAppedScript' ) ) {
    function autogenTemplateAppedScript() {
		global $remoteURL, $request, $apidata, $directoryURI, $parent, $themeVersion, $galleryLayout, $galleryColumn, $galleryFancybox, $wp, $servicepage;
		ob_start();
		?>
		// dynamic scripts here
		jQuery(document).ready( function($) {
				
			<?php if( isset( $servicepage->jsondata->background ) && is_array( $servicepage->jsondata->background ) && count( $servicepage->jsondata->background ) ): ?>
			<?php $bgautoplayInterval = isset($servicepage->jsondata->background) ? (int) $servicepage->jsondata->backgroundInterval : 3000; ?>
			jQuery('.atf-slider-content-bg').slick({
				autoplay: true,
				autoplaySpeed: <?php echo $bgautoplayInterval; ?> || 3000,
				<?php if( isset($servicepage->jsondata->backgroundEffect) && $servicepage->jsondata->backgroundEffect == 'fade' ): ?>
				fade: true,
				cssEase: 'linear',
				speed: 500,
				<?php endif; ?>
			});
			<?php endif; ?>

			<?php if( isset($servicepage->jsondata->gallery) && is_array($servicepage->jsondata->gallery) && count($servicepage->jsondata->gallery) ): ?>
				
				<?php if( $galleryLayout == 'carousel' ): ?>
					var slickv3 = jQuery('.slick-item-for-v3').slick({          
						centerMode: true,
						//centerPadding: '10px',
						slidesToShow: <?php echo $galleryColumn; ?> || 3,
						focusOnSelect: true, 
						responsive: [
							{
								breakpoint: 768,
								settings: {
									arrows: true,
									centerMode: true,
									//centerPadding: '10px',
									slidesToShow: 3
								}
							},
							{
								breakpoint: 480,
								settings: {
									arrows: true,
									centerMode: true,
									//centerPadding: '10px',
									slidesToShow: 1
								}
							}
						]
					});

					<?php if( $galleryFancybox ): ?>
					
					function slickv3FancySetter() {
						jQuery('.slick-item-for-v3 .slickv3_img_fancy').removeAttr('data-fancybox');
						jQuery('.slick-item-for-v3 .slick-center .slickv3_img_fancy').attr('data-fancybox', 'gallery');
					}

					slickv3FancySetter();

					slickv3.on("afterChange", function () {
						slickv3FancySetter();
					});
					<?php endif; ?>


				<?php elseif( $galleryLayout == 'carouselv2' ): ?>
					jQuery('.slick-item-for').slick({
						slidesToShow: 1,
						slidesToScroll: 1,
						arrows: false,
						fade: true,
						asNavFor: '.slick-item-nav',
						adaptiveHeight: true
					});

					jQuery(".slick-item-nav").slick({
						slidesToShow: <?php echo $galleryColumn; ?> || 4,
						slidesToScroll: 1,
						asNavFor: '.slick-item-for',
						dots: false,
						focusOnSelect: true, 
						responsive: [
						{
							breakpoint: 1025,
							settings: {
							slidesToShow: <?php echo $galleryColumn; ?> || 4,
							slidesToScroll: 1,
							infinite: true,
							}
						}
						]
					});

				<?php endif; ?>

			<?php endif; ?>



			// quick form submission here.

			$.fn.serializeObject = function() {
				var o = {};
				var a = this.serializeArray();
				$.each(a, function() {
					if (o[this.name]) {
						if (!o[this.name].push) {
							o[this.name] = [o[this.name]];
						}
						o[this.name].push(this.value || '');
					} else {
						o[this.name] = this.value || '';
					}
				});
				return o;
			};


			function apiRequestError(form, error) {
				if(!error.responseJSON || !error.responseJSON.errors) { return false; }
				for(var key in error.responseJSON.errors) {
					$(`${form} input[data-field=${key}], ${form} textarea[data-field=${key}], ${form} select[data-field=${key}]`).css({
						'border-color': 'red'
					});

					var message = error.responseJSON.errors[key];

					var elem = $(`${form} [data-field=${key}]`);

					if(elem.data('alias-field')) {
						message = message.replace(elem.data('alas-field'));
					}

					if(elem.data('custom-message')) {
						message = elem.data('custom-message');
					}

					elem.after(`<span class="data-error-response">${message}</span>`);

				}
			}

			function apiRequestErrorReset() {
				$('.data-error-response').remove();
				$(`[data-field]`).attr('style', '');
				$('.success_formQuoteSubmit, .success_formContactSubmit').html('');
				$('[data-message-output]').remove();
			}

			function apiRequestLoading(elem) {
				$.each($(`${elem} [data-btn-submit]`), function() {
					$(this).css({
						'opacity': 0.5,
						'pointer-events': 'none'
					});
					$(this).val('Loading...');
				});
			}

			function apiRequestFinish(elem) {
				$.each($(`${elem} [data-btn-submit]`), function() {
					$(this).css({
						'opacity': 1,
						'pointer-events': 'auto'
					});
					$(this).val($(this).data('text'));
				});
			}

			function setContactMessage(elem, content, type = 'success') {
				elem.html(`
					<div class="auto-gen-message ${type}" data-message-output>
						${content}
						<a href="#close" data-message-close>&times;</a>
					</div>
				`);
			}

			function scrollToElem_(elem) {
				$('html,body').animate({
					scrollTop: elem.offset().top
				}, 'slow');
			}

			$('html, body').delegate('[data-message-close]', 'click', function() {
				$(this).parent().remove();
				return false;
			});

			var formWebHookURL = '<?php echo carbon_get_theme_option('ponds_form_webhook'); ?>';

			$('.formQuoteSubmit').submit( function(e) {
				e.preventDefault();
				apiRequestErrorReset();
				const dataparam = $(this).serializeObject();
				var elem = '.formQuoteSubmit';
				try {
					var requestQuoute = '<?php echo carbon_get_theme_option('portal_admin'); ?>/api/v1/mail/quote';
					$.ajax({
						url: requestQuoute,
						method: 'POST',
						data: JSON.stringify(dataparam),
						contentType: 'application/json',
						dataType: 'json',
						success: function(res) {

							if(formWebHookURL) {
								var callbackURL = "callback=<?php echo home_url($wp->request); ?>";
								formWebHookURL += formWebHookURL.includes("?") ? `&${callbackURL}` : `?${callbackURL}`;
								window.location.href=formWebHookURL;
								return true;
							}

							setContactMessage(
								$('.success_formQuoteSubmit'),
								`<p>Thank you for submitting this form. We received your email.</p>`
							);

							apiRequestFinish(elem);
							$(elem)[0].reset();

							<?php if(carbon_get_theme_option('ponds_recaptcha_sitekey')): ?>
							grecaptcha.reset();
							<?php endif; ?>
						},
						error: function(res) {

							setContactMessage(
								$('.success_formQuoteSubmit'),
								`<p>Failed to submit your request, please try again.</p>`,
								'error'
							);

							apiRequestFinish(elem);
							apiRequestError(elem, res);
						},
						beforeSend: function() {
							apiRequestLoading(elem);
						}
					});
				} catch($errors) {

					setContactMessage(
						$('.success_formQuoteSubmit'),
						`<p>Failed to submit your request, please try again.</p>`,
						'error'
					);
				}
			});


			$('.formContactSubmit').submit( function(e) {
				e.preventDefault();
				apiRequestErrorReset();

				const dataparam = $(this).serializeObject();

				var elem = '.formContactSubmit';
				try {
					var requestQuoute = '<?php echo carbon_get_theme_option('portal_admin'); ?>/api/v1/mail/contact';
					$.ajax({
						url: requestQuoute,
						method: 'POST',
						data: JSON.stringify(dataparam),
						contentType: 'application/json',
						dataType: 'json',
						success: function(res) {

							if(formWebHookURL) {
								var callbackURL = "callback=<?php echo home_url($wp->request); ?>";
								formWebHookURL += formWebHookURL.includes("?") ? `&${callbackURL}` : `?${callbackURL}`;
								window.location.href=formWebHookURL;
								return true;
							}

							scrollToElem_($('#contact'));

							$('[data-progress-id]').remove();

							setContactMessage(
								$('.success_formContactSubmit'),
								`<p>Thank you for submitting this form. We received your email.</p>`
							);

							apiRequestFinish(elem);
							$(elem)[0].reset();

							<?php if(carbon_get_theme_option('ponds_recaptcha_sitekey')): ?>
							grecaptcha.reset();
							<?php endif; ?>
						},
						error: function(res) {

							scrollToElem_($('#contact'));

							setContactMessage(
								$('.success_formContactSubmit'),
								`<p>Failed to submit your request, please try again.</p>`,
								'error'
							);

							apiRequestFinish(elem);
							apiRequestError(elem, res);
						},
						beforeSend: function() {
							apiRequestLoading(elem);
						}
					});
				} catch($errors) {

					setContactMessage(
						$('.success_formContactSubmit'),
						`<p>Failed to submit your request, please try again.</p>`,
						'error'
					);
				}
			});

			var uploaderCounter = 0;
			async function uploadFileContact(file) {
				var formdata = new FormData();
				formdata.append('file', file);
				var requestQuoute = '<?php echo carbon_get_theme_option('portal_admin'); ?>/api/v1/upload/public';

				uploaderCounter++;
				
				var el = $(`
					<div data-progress-id="${uploaderCounter}">
						<input type="hidden" name="filenames" value="" class="filevaluename">
						<input type="hidden" name="files" value="" class="filevalue">
						<div class="progresstitlewrap">
							<div class="progressfilename">${file.name}</div>
							<div class="progressstatus">0%</div>
						</div>
						<span class="fileprogressbar">
							<span class="fileprogressfill"></span>
						</span>
					</div>
				`);
				
				var elem = $('[data-progresslists]').append(el);

				const result = await $.ajax({
					url: requestQuoute,
					method: 'POST',
					data: formdata,
					contentType: false,
					processData: false,
					async: true,
					dataType: 'json',
					xhr: function() {
						var xhr = new window.XMLHttpRequest();
						xhr.upload.addEventListener("progress", function(evt) {
							if (evt.lengthComputable) {
								var percentComplete = parseInt((evt.loaded / evt.total) * 100);
								
								el.find('.fileprogressfill').css({
									width: `${percentComplete}%`
								});

								el.find('.progressstatus').text(`${percentComplete}%`);
							}
						}, false)

						return xhr;
					},
					success: function(res) {
						var filenametext = el.find('.progressfilename').text();
						el.find('.progressfilename').html(`
							<a href="${res.path}" target="_blank">${filenametext}</a>
						`);
						el.find('.progressstatus').html(`
							<a href="#removefile" data-file-remove="${res.id}">
								<span aria-hidden="true" class="et-pb-icon set-social-icon p-10 soc-header">&#x51;</span>
							</a>
						`);
						el.find('.filevalue').val(res.path);
						el.find('.filevaluename').val(res.file_name);
					},
					error: function(error) {

						var errtxt = "Invalid file.";

						if(!error.responseJSON || !error.responseJSON.errors) { return false; }
						var errindex = 0;
						for(var key in error.responseJSON.errors) {
							if(errindex == 0) {
								errtxt = error.responseJSON.errors[key][0];
							}
							errindex++;
						}

						el.find('.fileprogressfill').css({
							'background': 'red'
						});

						el.find('.progressstatus').text(errtxt);

						setTimeout( function() {
							el.remove();
						}, 1000);
					}
				});

				return result;
			}


			$('[data-quickformcontact-files]').on('change', function(e) {
				var filelength = e.target.files.length;
				if( filelength > 3 ) { 
					alert('Please select 3 files per batch.');
					return false;
				}
				for( var i = 0; i < filelength; i++) {
					const res = uploadFileContact(e.target.files[i]);
				}
			});

			$('html, body').delegate('[data-file-remove]', 'click', function() {
				var id = $(this).data('file-remove');
				
				var parentelem = $(this).parent().closest('[data-progress-id]');
				$(this).parent('.progressstatus').html('Loading...');
				var requestQuoute = `<?php echo carbon_get_theme_option('portal_admin'); ?>/api/v1/upload/public/${id}?publicMedias=1`;

				$.ajax({
					url: requestQuoute,
					method: 'DELETE',
					contentType: 'application/json',
					dataType: 'json',
					success: function() {
						parentelem.remove();
					},
					error: function() {
						alert('Failed to remove this file.');
						$(this).parent('.progressstatus').html(`
							<a href="#removefile" data-file-remove="${id}">
								<span aria-hidden="true" class="et-pb-icon set-social-icon p-10 soc-header">&#x51;</span>
							</a>
						`);
					}
				});

				return false;
			});


		});

		<?php
		$html = ob_get_clean();
        return $html;
	}
}

wp_add_inline_script( 'auto-generate-slick', autogenTemplateAppedScript() );


if( !function_exists( 'autogenTemplateGMAPScript' ) ) {
	function autogenTemplateGMAPScript() {
		global $apidata;
		ob_start();
		?>
		<script>
		function ONSMapInit() {
		const contractor_latlng = {
			lat: <?php echo $apidata->lat; ?>, 
			lng: <?php echo $apidata->lng; ?>
		};

		const contractor_map = new google.maps.Map(document.getElementById('footermapjs'), {
			center: contractor_latlng,
			zoom: 9,
			mapTypeControl: false,
			scaleControl: false,
			scrollwheel: false,
			navigationControl: false,
			streetViewControl: false,
			zoomControl: false
		});

		<?php if(!$apidata->membership_tb_hide_map_pin): ?>
		<?php if(isset($apidata->jsondata->showAddress) && $apidata->jsondata->showAddress): ?>
		const contractor_paidIcon = "<?php echo get_stylesheet_directory_uri() . '/shortcodes/map/src/map-pin-paid.png'; ?>";
        const contractor_notPaidIcon = "<?php echo get_stylesheet_directory_uri() . '/shortcodes/map/src/map-pin-unpaid.png'; ?>";
		const contractor_mapmarker = new google.maps.Marker({
			position: contractor_latlng,
			map: contractor_map,
			icon: <?php echo $apidata->ispaid ? "contractor_paidIcon" : "contractor_notPaidIcon" ?>
		});
		<?php endif; ?>
		<?php endif; ?>
		}
		</script>
		<?php
		$html = ob_get_clean();
		echo $html;
	}
}
add_action( 'wp_head', 'autogenTemplateGMAPScript' );


// recaptcha js
if(carbon_get_theme_option('ponds_recaptcha_sitekey')):
add_action('wp_head', 'landing_page_generator_recaptcha');
function landing_page_generator_recaptcha() {
	ob_start();
	?>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<?php
	echo ob_get_clean();
};
endif;

if( isset( $servicepage->jsondata->headerinject ) && $servicepage->jsondata->headerinject ):
add_action('wp_head', 'landing_page_generator_wp_header');
function landing_page_generator_wp_header() {
	global $servicepage;
	echo $servicepage->jsondata->headerinject;
};
endif;


if( isset( $servicepage->jsondata->footerinject ) && $servicepage->jsondata->footerinject ):
add_action('wp_footer', 'landing_page_generator_wp_footer', 100);
function landing_page_generator_wp_footer() {
	global $servicepage;
	echo $servicepage->jsondata->footerinject;
};
endif;