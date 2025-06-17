<?php 
    global $remoteURL, $request, $apidata, $directoryURI, $parent, $themeVersion, $galleryLayout, $galleryColumn, $galleryFancybox;
?>

<div id="mosaic-container" class="gallery-container">
    <div id="mosaic" class="mosaic-row-<?php echo $galleryColumn; ?>">

		<?php foreach( $apidata->gallery as $galdata ): ?>
			<?php if( isset( $galdata->path ) && is_object($galdata) ): ?>
				<?php 
					$galwidth = isset($galdata->width) ? (int) $galdata->width : 'auto';
					$galheight = isset($galdata->height) ? (int) $galdata->height : 'auto';
					$galtitle = isset($galdata->title) ? $galdata->title : '';
					$galalt = isset($galdata->alt) ? $galdata->alt : $galtitle;
				?>
				
				<div class="grid card">
					<div class="card-image">
						<?php if( $galleryFancybox ): ?>
							<a href="<?php echo $galdata->path; ?>" data-fancybox="mosaic-gallery" data-caption="<?php echo $galalt; ?>">
								<img src="<?php echo $galdata->path; ?>" width="<?php echo $galwidth; ?>" height="<?php echo $galheight; ?>" alt="<?php echo $galalt; ?>">
							</a>
						<?php else: ?>
							<img src="<?php echo $galdata->path; ?>" width="<?php echo $galwidth; ?>" height="<?php echo $galheight; ?>" alt="<?php echo $galalt; ?>">
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>

	</div>
</div>