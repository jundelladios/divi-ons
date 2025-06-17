<?php 
    global $remoteURL, $request, $apidata, $directoryURI, $parent, $themeVersion;
?>
<?php if( isset( $apidata->jsondata->infolinks ) && is_array( $apidata->jsondata->infolinks ) && count( $apidata->jsondata->infolinks ) ): ?>
<div id="info-links-section">
   <div>
      <div>
         <div class="info-links-section-title">
            <div class="pond-text-editor-container">
               <h3 class="font-45 text-center"><?php echo $apidata->name; ?></h3>
                <h4 class="font-25 text-center">Informational Links On The Web</h4>
            </div>
         </div>
         <div class="info-links-boxes-container">
            <?php $infolinkIndex = 0; ?>
            <?php foreach( $apidata->jsondata->infolinks as $infolink ): ?>
            <!-- Info Link Box -->
            <?php if( isset( $infolink->title ) && !empty( $infolink->title ) ): ?>
            <div 
            class="info-link-box" 
            title="<?php echo $infolink->title;  ?>" 
            <?php if(isset($infolink->width) && !empty($infolink->width)): ?>
            style="width: <?php echo $infolink->width; ?>%;"
            <?php endif; ?>
            >
               <div class="pond-text-editor-container">
                  <!-- Info Links Title -->
                  
                  <div class="info-link-text-editor-title">
                     <h4><?php echo $infolink->title;  ?></h4>
                  </div>
                  
                  <!-- Info Links Title End -->
                  <!-- Info Links Text Editor -->
                  <?php if( isset( $infolink->content ) && $infolink->content ): ?>
                  <div class="info-link-text-editor-content">
                     <?php echo $infolink->content; ?>
                  </div>
                  <?php endif; ?>
                  <!-- Info Text Editor End -->
               </div>
            </div>
            <?php endif; ?>
            <!-- Info Link Box End -->
            <?php $infolinkIndex++; endforeach; ?>
         </div>
      </div>
   </div>
</div>
<?php endif; ?>