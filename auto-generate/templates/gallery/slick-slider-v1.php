<?php 
    global $remoteURL, $request, $apidata, $directoryURI, $parent, $themeVersion, $galleryLayout, $galleryColumn, $galleryFancybox;
?>

<div id="slick-slider-v1" class="gallery-container m-no-gutter-30">

	<div class="slick-slider-v1-container">
		<div class="slick-container" >


			<div class="slick-item-for">
				<?php foreach( $apidata->gallery as $galdata ): ?>
					<?php if( isset( $galdata->path ) && is_object($galdata) ): ?>
						<?php 
							$galwidth = isset($galdata->width) ? (int) $galdata->width : 'auto';
							$galheight = isset($galdata->height) ? (int) $galdata->height : 'auto';
							$galtitle = isset($galdata->title) ? $galdata->title : '';
							$galalt = isset($galdata->alt) ? $galdata->alt : $galtitle;
						?>
						<div class="slick-item adaptive-height">
							<?php if( $galleryFancybox ): ?>
								<a href="<?php echo $galdata->path; ?>" data-fancybox="gallery" data-caption="<?php echo $galalt; ?>">
									<img src="<?php echo $galdata->path; ?>" width="<?php echo $galwidth; ?>" height="<?php echo $galheight; ?>" alt="<?php echo $galalt; ?>">
								</a>
							<?php else: ?>
								<img src="<?php echo $galdata->path; ?>" width="<?php echo $galwidth; ?>" height="<?php echo $galheight; ?>" alt="<?php echo $galalt; ?>">
							<?php endif; ?>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>




			<div class="slider slider-nav slick-item-nav">
				<?php foreach( $apidata->gallery as $galdata ): ?>
						<?php if( isset( $galdata->path ) && is_object($galdata) ): ?>
							<?php 
								$galwidth = isset($galdata->width) ? (int) $galdata->width : 'auto';
								$galheight = isset($galdata->height) ? (int) $galdata->height : 'auto';
								$galtitle = isset($galdata->title) ? $galdata->title : '';
								$galalt = isset($galdata->alt) ? $galdata->alt : $galtitle;
							?>
							<div class="slick-item">
								<img src="<?php echo $galdata->path; ?>" width="<?php echo $galwidth; ?>" height="<?php echo $galheight; ?>" alt="<?php echo $galalt; ?>">
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
			</div>

		</div>
	</div>

</div>