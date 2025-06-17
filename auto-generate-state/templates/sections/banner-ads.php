<?php 

global $allCustomerData;

$bannersAds = array_column(
	array_filter($allCustomerData, function($cs) {
		return is_array($cs->banner_ads) && count($cs->banner_ads);
	}),
	'banner_ads'
);

if( count( $bannersAds ) && is_array( $bannersAds ) ):

?>

<div id="banner-adds-div" class="">
	<div class="nf nf-container pb-0">
		<div class="slick-container" >
			<div class="banner-adds-slick-item-solo">

				<?php foreach( $bannersAds as $prim ): ?>
					<?php foreach( $prim as $banner ): ?>
						<?php if( is_object( $banner ) && isset( $banner->path ) ): ?>
							<div class="slick-item adaptive-height">
								<?php if( isset( $banner->link ) && !empty( $banner->link ) ): ?>
								<a href="<?php echo $banner->link; ?>" data-caption="<?php echo $banner->alt; ?>" target="_blank">
								<?php endif; ?>
									
									<img src="<?php echo $banner->path ?>" alt="<?php echo $banner->alt; ?>" width="<?php echo $banner->width; ?>" height="<?php echo $banner->height; ?>">
									
								<?php if( isset( $banner->link ) && !empty( $banner->link ) ): ?>
								</a>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endforeach; ?>
                
			</div>
		</div>
	</div>
</div>

<?php

endif;