<?php

global $post;

$gendomain = get_post_meta(get_the_ID(), 'generator_domain', true);

$gridChunk = 8;
$gridModulo = 4;

$stateParams = [
	'withsettings' => 1,
	'withcounties' => 1,
	'slug' => $post->post_name,
	'domain' => $gendomain
];

$remoteStateURL = carbon_get_theme_option('portal_admin') . '/api/v1/states?' . http_build_query($stateParams);
$requestStateAPI = wp_remote_get($remoteStateURL); 
$stateData = json_decode( wp_remote_retrieve_body( $requestStateAPI ) );
$theState = $stateData[0];


$customerParams = [
	'servicespageslists' => 1,
	'default_coordinate_ip' => 1,
	'orderby' => 'membership.priority DESC',
	'locatortagfilter' => 1,
	'tagdomains' => $gendomain,
	'tagstate' => $theState->state,
	'all' => 1
];

if(isset($_COOKIE['ponds-geo'])) {
	$pondsgeo = json_decode(str_replace("\\", "",$_COOKIE['ponds-geo']));
	if($pondsgeo && is_object($pondsgeo)) {
		$customerParams['lat'] = $pondsgeo->lat;
		$customerParams['lng'] = $pondsgeo->lng;
		$customerParams['orderby'] = 'distance';
	}
} else {
	// default ip

}

$remoteCustomersURL = carbon_get_theme_option('portal_admin') . '/api/v1/customer?' . http_build_query($customerParams);
$requestCustomerAPI = wp_remote_get($remoteCustomersURL);
$allCustomerData = json_decode( wp_remote_retrieve_body( $requestCustomerAPI ) );
$customerData = array_filter($allCustomerData, function($cs) {
    return ($cs->ishidden == 0);
});

$directoryURI = get_stylesheet_directory_uri();
$parent = wp_get_theme()->parent();
$themeVersion = $parent->Version;
$cssAssets = [
	[
		'id' => 'auto-generate-state',
		'href' => "$directoryURI/auto-generate-state/style.css?ver=$themeVersion"
	],
	[
		'id' => 'auto-generate-state-mobile',
		'href' => "$directoryURI/auto-generate-state/style-mobile.css?ver=$themeVersion"
	],
	// [
	// 	'id' => 'auto-generate-state-font',
	// 	'href' => "$directoryURI/auto-generate-state/font.css?ver=$themeVersion"
	// ],
	[
		'id' => 'auto-generate-state-slick',
		'href' => "$directoryURI/auto-generate-state/slick/slick.css?ver=$themeVersion"
	],
	[
		'id' => 'auto-generate-state-slick-theme',
		'href' => "$directoryURI/auto-generate-state/slick/slick-theme.css?ver=$themeVersion"
	],
	[
		'id' => 'auto-generate-state-fancybox',
		'href' => "$directoryURI/auto-generate-state/fancybox.css?ver=$themeVersion"
	]
];

$jsAssets = [
	[
		'id' => 'auto-generate-state-slick',
		'href' => "$directoryURI/auto-generate-state/slick/slick.min.js?ver=$themeVersion"
	],
	[
		'id' => 'auto-generate-state-fancybox',
		'href' => "$directoryURI/auto-generate-state/fancybox.js?ver=$themeVersion"
	],
	[
		'id' => 'auto-generate-state',
		'href' => "$directoryURI/auto-generate-state/script.js?ver=$themeVersion"
	]
];

// css assets
foreach( $cssAssets as $csselem ) {
    wp_enqueue_style( $csselem['id'], $csselem['href'] );
}

// js assets
foreach( $jsAssets as $jselem ) {
    wp_enqueue_script( $jselem['id'], $jselem['href'], array( 'jquery' ), $themeVersion, true );
}


function _ssgen_contentFormat($thedata, $content) {

	$keys = [];

	$replaces = [];

	foreach($thedata as $key => $value) {

		$keys[] = '['.$key.']';
		$keys[] = '['.$key.'-capitalize]';
		$keys[] = '['.$key.'-uppercase]';
		$keys[] = '['.$key.'-lowercase]';

		$replaces[] = $value;
		$replaces[] = ucwords($value);
		$replaces[] = strtoupper($value);
		$replaces[] = strtolower($value);

	}

	return str_replace($keys, $replaces, $content);

} 


function _ssgen_content($content) {

	global $theState;

	return _ssgen_contentFormat( [
		'state' => $theState->state,
		'abv' => $theState->abv,
		'state-sanitized' => sanitize_title($theState->sanitized_state),
		'abv-sanitized' => sanitize_title($theState->sanitized_abv)
	],$content);

}


// grid preloaders
ob_start();
for($i=0;$i<4;$i++):
?>
<div class="customer-grid preloader hide">
    <div>
        <div class="csgridheader">

            <div style="width: 200px;background: #ccc;height:25px;margin:0 auto;margin-bottom:10px;"></div>
            <div style="width: 300px;background: #ccc;height:20px;margin:0 auto;margin-bottom:10px;"></div>
            <div style="width: 100px;background: #ccc;height:20px;margin:0 auto;margin-bottom:10px;"></div>

            <div class="cs-grid-btn-bottom">
                <div style="width: 50%;background: #ccc;height:50px;margin:0 auto;margin:5px;"></div>
                <div style="width: 50%;background: #ccc;height:50px;margin:0 auto;margin:5px;"></div>
            </div>

        </div>
    </div>
</div>
<?php
endfor;
$gridPreloaders = ob_get_clean();
// end of grid preloaders



// dummy
ob_start();
$iconpackage = carbon_get_theme_option('ponds_icon_package');
?>
<div class="customer-grid items">
    <div>
        <div class="csgridheader">
            <h3 class="csgridtitle">YOUR BUSINESS HERE!</h3>
            <p>123 Main Street, Town, ST 12345</p>
            <p><a href="<?php echo carbon_get_theme_option( 'ponds_inquiry_url' ); ?>" target="_blank">( List your business here! )</a></p>
        </div>
        <div class="cs-grid-btn-bottom">
            <a href="<?php echo carbon_get_theme_option( 'ponds_inquiry_url' ); ?>" target="_blank" class="cbtn nf-1-button">
			<?php if($iconpackage=="et"): ?>
				<span class="et-pb-icon">&#xe060;</span>
			<?php else: ?>
				<i class="fa fa-info-circle"></i>
			<?php endif; ?> 
			Get Listed Here</a>
        </div>
    </div>
</div>
<?php
$thedummygrid = ob_get_clean();
// end dummy


function custom_templatemap_enqueue_scripts() {
	
	wp_enqueue_style( 'generator-sc', get_stylesheet_directory_uri() . '/shortcodes/generator-sc.css' );

	$mapApi = carbon_get_theme_option('ponds_map_api');
  
	if( $mapApi ): 
  
	wp_enqueue_script( 'map-generator-shortcode', "https://maps.googleapis.com/maps/api/js?key=$mapApi&v=beta", '', '', true );
  
	wp_enqueue_script( 'map-generator-cluster', get_stylesheet_directory_uri() . '/shortcodes/map/src/markercluster.js', '', '', true );
  
	endif;

	wp_enqueue_script( 'map-generator-cookie', get_stylesheet_directory_uri() . '/assets/js-cookie.js', '', '', true );
  
  }
  
  add_action( 'wp_enqueue_scripts', 'custom_templatemap_enqueue_scripts' );



  function customerMembersHtmlData($args) {

	$membership = $args['membership'];

	global $thedummygrid, $gridPreloaders, $customerData, $gridChunk, $gridModulo, $domainconfigs;

	$customermemberships = array_filter($customerData, function($cs) use($membership) {
		return ($cs->membership == $membership);
	});

	$chunkCustomers = array_chunk( $customermemberships, $gridChunk );

	$numberOfChunkedCustomers = count( $chunkCustomers );

	$autoDummyInitCount = count( $customermemberships );

	// auto dummy
	ob_start();

	while( ($autoDummyInitCount % $gridModulo) != 0 ):

	echo $thedummygrid;

	$autoDummyInitCount++;

	endwhile;

	$autodummydata = ob_get_clean();


	ob_start();

	if( count( $chunkCustomers ) ):

		$iconpackage = carbon_get_theme_option('ponds_icon_package');

		?>

		<div class="nf nf-container customersgriddata" data-membership="<?php echo $membership; ?>">

			<?php 

			$chunkindex = 0;

			foreach( $chunkCustomers as $regc ): 

			?>

				<div 
				class="cs-grid-row <?php if( $chunkindex == 0 ): echo "show"; endif; ?>"
				data-chunk-index="<?php echo $chunkindex; ?>"
				>

				<div 
				class="customers grid-module-wrapper generator-sc"
				>

					<?php foreach($regc as $cs): $cs = (array) $cs; ?>


						<?php if(count($cs['servicespageslists'])): ?>
							<?php require get_stylesheet_directory() . '/auto-generate-state/templates/servicespages.php'; ?>
						<?php endif; ?>


						<div class="customer-grid items">
							<div>
								<div class="csgridheader">
									<h3 class="csgridtitle"><?php echo $cs['name']; ?></h3>
									
									<?php if(!$cs['membership_tb_hide_address']): ?>
									<?php if( isset($cs['jsondata']->altaddress) ): ?>
										<p><?php echo $cs['jsondata']->altaddress; ?></p>
									<?php else: ?>
										<?php if( isset( $cs['address'] ) && $cs['jsondata']->showAddress ): ?>
											<p><?php echo $cs['address']; ?></p>
										<?php endif; ?>
										<p><?php echo isset( $cs['city'] ) ? $cs['city']: ''; ?><?php echo isset( $cs['servicestates'] ) ? ', '.$cs['servicestates']: ''; ?><?php echo isset( $cs['postalcode'] ) ? ' '.$cs['postalcode']: ''; ?></p>
									<?php endif; ?>	
									<?php endif; ?>

									<?php if( $cs['ispaid'] && !$cs['membership_tb_hide_contact_infos'] ): ?>
									<p>
										<a href="<?php echo 'https://'.$cs['domain'].'/'.$cs['slug']; ?>/#contact" target="_blank">Contact</a>
										<?php if( isset( $cs['phone'] ) ): ?>
										<span>Or Call</span>
										<a href="<?php echo apply_filters("ons_phone_format_filter_link", $cs['phone']); ?>"><?php echo $cs['phone']; ?></a>
										<?php endif; ?>
									</p>
									<?php endif; ?>

									<?php if(count($cs['servicespageslists']) && !$cs['membership_tb_hide_services']): ?>
									<p><a href="#servicespages" style="display:block;" class="services-pages-link has-custom-modal" data-modal-popup="our-services-<?php echo $cs['id']; ?>">Services Pages</a></p>
									<?php endif; ?>
									
									<?php if( !$cs['ispaid'] ): ?>
									<p><a href="<?php echo carbon_get_theme_option( 'ponds_inquiry_url' ); ?>" target="_blank">( Is this your business? )</a></p>
									<?php endif; ?>
								</div>
								
								<!--
								<div class="mapframe">
									<iframe src="https://maps.google.com/maps?q=<?php echo $cs['lat']; ?>,<?php echo $cs['lng']; ?>&amp;hl=es;z=14&amp;output=embed" width="100%" height="250" style="border:0;" loading="lazy"></iframe>
								</div>
									-->
									
								<div class="cs-grid-btn-bottom">
								<?php if( $cs['ispaid'] ): ?>
									<a href="<?php echo 'https://'.$cs['domain'].'/'.$cs['slug'];  ?>/" target="_blank" class="cbtn nf-1-button">
									<?php if($iconpackage=="et"): ?>
										<span class="et-pb-icon">&#xe060;</span>
									<?php else: ?>
										<i class="fa fa-info-circle"></i>
									<?php endif; ?> 
										Learn More</a>

									<?php if(isset( $cs['jsondata']->showDirectionButton ) && $cs['jsondata']->showDirectionButton && !$cs['membership_tb_hide_directions']): ?>
									<a href="https://www.google.com/maps/search/<?php echo $cs['lat']; ?>,<?php echo $cs['lng']; ?>" target="_blank" class="cbtn nf-1-button">
									<?php if($iconpackage=="et"): ?>
										<span class="et-pb-icon">&#xe01c;</span> 
									<?php else: ?>
										<i class="fa fa-compass"></i>
									<?php endif; ?> 
									Get Directions</a>
									<?php endif; ?>
								<?php else: ?>
									<a href="<?php echo 'https://'.$cs['domain'].'/'.$cs['slug'];  ?>/" target="_blank" class="cbtn nf-1-button">
									<?php if($iconpackage=="et"): ?>
										<span class="et-pb-icon">&#xe060;</span>
									<?php else: ?>
										<i class="fa fa-info-circle"></i>
									<?php endif; ?> 
									Get Listed Here</a>
								<?php endif; ?>
								</div>

							</div>
						</div>

					<?php endforeach; ?>

					<?php if( $chunkindex == ($numberOfChunkedCustomers-1) ): echo  $autodummydata; endif; ?>

					<?php echo $gridPreloaders; ?>

				</div>

				<?php if( $chunkindex+1 != $numberOfChunkedCustomers ): ?>
				<div class="customer-loadmoregrid">
					<a href="#showmore" data-chunk-next="<?php echo $chunkindex; ?>" class="nf-1-button" style="margin: 0 auto;">Show More</a>
				</div>
				<?php endif; ?>

				</div>
				
				<?php $chunkindex++; endforeach; ?>

			</div>

			</div>

		<?php

	else:
	
	// if empty generate auto dummy
		?>
		<div class="nf nf-container customersgriddata" data-membership="<?php echo $membership; ?>">
			<div 
			class="cs-grid-row show"
			>
				<div 
				class="customers grid-module-wrapper generator-sc"
				>
					<?php for($i=0; $i<$gridModulo;$i++): ?>
					<?php echo $thedummygrid; ?>
					<?php endfor; ?>
					
					<?php echo $gridPreloaders; ?>
				</div>
			</div>
		</div>
		<?php

	endif;


	$html = ob_get_clean();

	return $html;

  }