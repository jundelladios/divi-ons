<?php

$scargs = shortcode_atts( array(
    'primarycolor' => '#7b1fa2',
    'hovercolor' => '#4a0072',
    'secondarycolor' => '#00796b',
    'tertiarycolor' => '#387002',
    'perbatch' => 6,
    'perrowlg' => 2,
    'perrowmd' => 2,
    'perrowsm' => 1,
    'perrowxs' => 1,
    'perrow' => 3,
    'statevalue' => '',
    'autodummy' => 1,
    'lat' => 37.8393332,
    'lng' => -84.2700179,
    'membership_id' => null
  ), $args );

  $apiRequest = carbon_get_theme_option('portal_admin') . "/api/v1/customer";

  $params = [
    'limit' => $scargs['perbatch'],
    'page' => 1,
    'ishidden' => 0,
    'orderby' => 'customers.resultpriority DESC, customers.ispaid DESC'
  ];

  if( $scargs['statevalue'] ) {

    $params['state'] = $scargs['statevalue'];

  }

  if($scargs['membership_id']) {

      $params['membership_id'] = $scargs['membership_id'];

  }

  $unid = wp_unique_id('map_grid_sc_');

  $apiRequest = carbon_get_theme_option('portal_admin') . "/api/v1/customer?" . http_build_query($params);
  $response = wp_remote_get( $apiRequest );
  $customers     = json_decode( wp_remote_retrieve_body( $response ), true );
  $paginated = $customers['pagination'];

  if( isset( $customers['data'] ) ):

  $totalcs = count($customers['data']);

  require_once get_stylesheet_directory() . '/shortcodes/grid/style.php';

?>

<div class="customers grid-module-wrapper generator-sc">
    <?php foreach( $customers['data'] as $cs ): ?>
        <div class="customer-grid">

            <div>
                <div class="csgridheader">
                    <h3 class="csgridtitle"><?php echo $cs['name']; ?></h3>
                    <p><?php echo isset($cs['address']) ? $cs['address'] : ''; ?><?php echo isset( $cs['servicestates'] ) ? ', '.$cs['servicestates']: ''; ?><?php echo isset( $cs['postalcode'] ) ? ' '.$cs['postalcode']: ''; ?></p>
                    
                    <?php if( $cs['ispaid'] ): ?>
                    <p>
                        <a href="<?php echo 'https://'.$cs['domain'].'/'.$cs['slug']; ?>/#contact" target="_blank">Contact</a>
                        <?php if( isset( $cs['phone'] ) ): ?>
                        <span>Or Call</span>
                        <a href="<?php echo apply_filters("ons_phone_format_filter_link", $cs['phone']); ?>"><?php echo $cs['phone']; ?></a>
                        <?php endif; ?>
                    </p>
                    <?php else: ?>
                    <p><a href="<?php echo carbon_get_theme_option( 'ponds_inquiry_url' ); ?>" target="_blank">( Is this your business? )</a></p>
                    <?php endif; ?>
                </div>
                
                <div class="mapframe">
                    <iframe src="https://maps.google.com/maps?q=<?php echo $cs['lat']; ?>,<?php echo $cs['lng']; ?>&amp;hl=es;z=14&amp;output=embed" width="100%" height="250" style="border:0;" loading="lazy"></iframe>
                </div>
                    
                <div class="cs-grid-btn-bottom">
                <?php if( $cs['ispaid'] ): ?>
                    <a href="<?php echo 'https://'.$cs['domain'].'/'.$cs['slug'];  ?>/" target="_blank" class="cbtn nf-1-button"><span class="et-pb-icon">&#xe060;</span> Learn More</a>
                    <?php if(isset( $cs['jsondata']->showDirectionButton ) && $cs['jsondata']->showDirectionButton && !$cs['membership_tb_hide_directions']): ?>
                    <a href="https://www.google.com/maps/search/<?php echo $cs['lat']; ?>,<?php echo $cs['lng']; ?>" target="_blank" class="cbtn nf-1-button"><span class="et-pb-icon">&#xe01c;</span> Get Directions</a>
                    <?php endif; ?>
                <?php else: ?>
                    <a href="<?php echo 'https://'.$cs['domain'].'/'.$cs['slug'];  ?>/" target="_blank" class="cbtn nf-1-button"><span class="et-pb-icon">&#xe060;</span> Get Listed Here</a>
                <?php endif; ?>
                </div>

            </div>

        </div>
    <?php endforeach; ?>
    
    <?php if( $scargs['autodummy'] ): ?>
    <?php while( ($totalcs % $scargs['perrow']) != 0 ): ?>
        <div class="customer-grid">
            <div>
                <div class="csgridheader">
                    <h3 class="csgridtitle">YOUR BUSINESS HERE!</h3>
                    <p>123 Main Street, Town, ST 12345</p>
                    <p><a href="<?php echo carbon_get_theme_option( 'ponds_inquiry_url' ); ?>" target="_blank">( List your business here! )</a></p>
                </div>
                <div class="mapframe">
                    <iframe src="https://maps.google.com/maps?q=<?php echo $scargs['lat']; ?>,<?php echo $scargs['lng']; ?>&amp;hl=es;z=14&amp;output=embed" width="100%" height="250" style="border:0;" loading="lazy"></iframe>
                </div>
                <div class="cs-grid-btn-bottom">
                    <a href="<?php echo carbon_get_theme_option( 'ponds_inquiry_url' ); ?>" target="_blank" class="cbtn nf-1-button"><span class="et-pb-icon">&#xe060;</span> Get Listed Here</a>
                </div>
            </div>
        </div>
    <?php $totalcs++; endwhile; ?>
    <?php endif; ?>
</div>

<script type="text/javascript"></script>

<?php endif; ?>