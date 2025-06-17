<?php 
global $remoteURL, $request, $apidata, $directoryURI, $parent, $themeVersion;
?>

<div class="success_formQuoteSubmit"></div>

<form id="atf-form" method="post" target="gform_ajax_frame_2" class="h-full formQuoteSubmit">
    <div class="">
        <div class="field-full-name field template-row template-no-gutters required">
            <h5 class="required text-italic">(Required)</h5>
        </div>

        <input type="hidden" name="customer_id" value="<?php echo $apidata->id;; ?>" />

        <div class="field-full-name field template-row template-no-gutters grid grid-template-6-12 mb-10 grid-gap-1-percent">
            <div class="first-name-container">
                <div>
                    <div class="field-full-name field template-row template-no-gutters grid grid-template-6-12 mb-10">
                      <div class="first-name-container">
                          <div>
                              <input type="text" name="firstname" class="first-name text-bold" placeholder="First" data-field="firstname">
                          </div>
                      </div>
                      <div class="last-name-container">
                          <div>
                              <input type="text" name="lastname" class="last-name text-bold" placeholder="Last" data-field="lastname">
                          </div>
                      </div>
                  </div>
                </div>
            </div>
            <div class="last-name-container">
                <div>
                    <div class="field-full-name field template-row template-no-gutters grid grid-template-6-12 mb-10">
                      <div class="field-phone field mb-10">
                          <div class="phone-container">
                              <input type="text" data-mask="<?php echo carbon_get_theme_option('ponds_phone_mask'); ?>" name="phone" class="phone text-bold" data-field="phone">
                          </div>
                      </div>
                      <div class="field-email field mb-10">
                          <div class="email-container">
                              <input type="email" name="email" class="email text-bold" placeholder="Email" data-field="email">
                          </div>
                      </div>
                  </div>
                </div>
            </div>
        </div>      

        <?php if( isset( $apidata->services ) && is_array( $apidata->services ) && count($apidata->services) ): $serviceChunked = array_chunk( $apidata->services, 3 ); ?>
        <div class="field-sevices-offered field mb-10">
            <div id="quick-form-services" class="quick-form-services">
                <div class="services-container">
                   <div class="services-sub-container">                   
                      <div class="pond-text-editor-container">
                         <div class="services-boxes">
                            <h4>Services</h4>
                         </div>
                      </div>
                      <div class="field-full-name field template-row template-no-gutters required">
                           <h5 class="required text-italic">(Required)</h5>
                     </div>   

                     <?php foreach( $serviceChunked as $schunk ): ?>
                      <div class="grid grid-template-4-12">
                         <?php foreach( $schunk as $srvicech ): ?>
                         <div class="services-boxes">
                            <div class="mb-10">
                               <label class="pointer font-w-100"> 
                                 <input type="checkbox" name="services" value="<?php echo $srvicech; ?>">
                                 <?php echo $srvicech; ?></label>
                            </div>
                         </div>
                         <?php endforeach; ?>
                      </div>
                      <?php endforeach; ?>

                      <div data-field="services" data-custom-message="Please select services."></div>

                   </div>
                </div>                
            </div>
        </div>
        <?php else: ?>
            <div style="margin-bottom: 20px;"></div>
        <?php endif; ?>


        <div class="field-message field mb-10">
            <div class="message-container">
                <textarea class="font-15 message w-full p-15 bg-eee border-width-1 border-color-eee text-bold" placeholder="Message" name="message"></textarea>
            </div>
        </div>
    </div>
	
	<div class="field-consent field" style="margin-bottom: 10px; margin-top:10px;">
        <label>Consent</label>
        <div class="mb-10">
            <label for="consentpopup" class="cursor-pointer font-w-100 cursor-pointer"><input type="checkbox" id="consentpopup" name="terms" value="1" style="width:auto;"> I have read and agree to terms & conditions</label><span class="br"></span>
        </div>

        <a href="<?php echo carbon_get_theme_option('ponds_terms_url'); ?>" target="_blank" class="terms-services" data-field="terms" data-custom-message="You must agree to terms and conditions.">
            <p>Please Review Our Terms & Conditions</p>
        </a>
    </div>
    
    <?php if(carbon_get_theme_option('ponds_recaptcha_sitekey')): ?>
    <div class="g-recaptcha" data-field="g-recaptcha-response" data-custom-message="Please confirm if you are not a robot." style="margin: 20px 0;" data-sitekey="<?php echo carbon_get_theme_option('ponds_recaptcha_sitekey'); ?>"></div>
    <?php endif; ?>

    <div class="field-submit field">
        <div class="message-container pt-10">
            <input class="button float-left bg-024B79 cursor-pointer font-25 text-uppercase text-white" type="submit" name="submit" value="Submit" data-text="Submit" data-btn-submit>
        </div>
    </div>
</form>