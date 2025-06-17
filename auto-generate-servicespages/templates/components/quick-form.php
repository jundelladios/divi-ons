<?php 
    global $remoteURL, $request, $apidata, $directoryURI, $parent, $themeVersion;
?>

<div class="success_formContactSubmit"></div>

<form method="post" enctype="multipart/form-data" target="gform_ajax_frame_2" id="quick-form-container" class="formContactSubmit">

    <input type="hidden" name="customer_id" value="<?php echo $apidata->id; ?>" />

    <div class="field-full-name field-adjust">
        <label>Name <span class="required">*</span></label>
        <div class=" field grid grid-template-6-12 grid-gap-adjust">
            <div class="first-name-container ">
                <div class=" i-container">                                      
                    <input type="text" name="firstname" class="first-name" placeholder="First" data-field="firstname">
                </div>
            </div>
            <div class="last-name-container ">
                <div class=" i-container">
                    <label></label>
                    <input type="text" name="lastname" class="last-name" placeholder="Last">
                </div>
            </div>
        </div>
    </div>
    <div class="field-phone-email field-adjust">
        <div class=" field grid grid-template-6-12 grid-gap-adjust">
            <div class="first-name-container ">
                <div class="field-phone field">
                    <label>Phone <span class="required">*</span></label>
                    <div class="phone-container i-container">
                        <input type="text" data-mask="<?php echo carbon_get_theme_option('ponds_phone_mask'); ?>" name="phone" class="phone" data-field="phone">
                    </div>
                </div>
            </div>
            <div class="last-name-container ">
                <div class="field-email field">
                    <label>Email <span class="required">*</span></label>
                    <div class="email-container i-container">
                        <input type="email" name="email" class="email" placeholder="Email" data-field="email">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="field-address-main field field-adjust">
        <label>Address <span class="required">*</span></label>
        <div class="city-state-container i-container grid grid-template-6-12 grid-gap-adjust">
            <div class=" padding-r-child-5">
                <div class="address-1-container i-container">
                    <input type="text" name="address" class="address_1" data-field="address">
                    <label>Street Address</label>
                </div>
            </div>
            <div class=" padding-l-child-5">
                <div class="address-2-container i-container">
                    <input type="text" name="address2" class="address_1">
                    <label>Address Line 2</label>
                </div>
            </div>
        </div>
        <div class="grid grid-template-6-12 grid-gap-adjust">
          <div class=" city-state-container i-container grid grid-template-6-12">
              <div class=" padding-r-child-5">
                  <div>
                      <input type="text" name="city" class="address_1" data-field="city">
                      <label>City</label>
                  </div>
              </div>
              <div class=" padding-l-child-5">
                  <div>
                      <input type="text" name="state" class="address_1" data-field="state">
                      <label>State / Province / Region</label>
                  </div>
              </div>
          </div>
        <div class="city-state-container i-container grid grid-template-6-12">
            <div class=" padding-r-child-5">
                <div>
                    <input type="text" name="zip" class="address_1" data-field="zip">
                    <label>ZIP / Postal Code</label>
                </div>
            </div>
            <div class=" padding-l-child-5">
                <div>
                    <div class="address-country">
                        <select name="country" id="country" aria-required="true" data-field="country">
                           <option value="" selected="selected">Select Country</option>
                           <?php $countryLists  = ["Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bonaire, Sint Eustatius and Saba", "Bosnia and Herzegovina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos Islands", "Colombia", "Comoros", "Congo, Democratic Republic of the", "Congo, Republic of the", "Cook Islands", "Costa Rica", "Croatia", "Cuba", "Curaçao", "Cyprus", "Czech Republic", "Côte d'Ivoire", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Eswatini (Swaziland)", "Ethiopia", "Falkland Islands", "Faroe Islands", "Fiji", "Finland", "France", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guernsey", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and McDonald Islands", "Holy See", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Isle of Man", "Israel", "Italy", "Jamaica", "Japan", "Jersey", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Kuwait", "Kyrgyzstan", "Lao People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Montenegro", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "North Korea", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Palestine, State of", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Romania", "Russia", "Rwanda", "Réunion", "Saint Barthélemy", "Saint Helena", "Saint Kitts and Nevis", "Saint Lucia", "Saint Martin", "Saint Pierre and Miquelon", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Sint Maarten", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia", "South Korea", "South Sudan", "Spain", "Sri Lanka", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Timor-Leste", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "US Minor Outlying Islands", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands, British", "Virgin Islands, U.S.", "Wallis and Futuna", "Western Sahara", "Yemen", "Zambia", "Zimbabwe", "Åland Islands"]; ?>
                           <?php foreach( $countryLists as $country ): ?>
                           <option value="<?php echo $country; ?>"><?php echo $country; ?></option>
                           <?php endforeach; ?>
                        </select>
                    </div>
                    <label>Country</label>
                </div>
            </div>
        </div>
        </div>
    </div>
   
    <?php if( isset($apidata->jsondata->quickformFields) && is_array($apidata->jsondata->quickformFields) ): ?>

    <div class="field-service field">
      <div id="quick-form-services">


      <?php 
      $quickfielddynamicindexMain = 0;
      foreach( $apidata->jsondata->quickformFields as $qckfields ): ?>

        <?php 
        $qcfieldtype = "text";
        $qcfieldsupports = ['checkbox', 'radio', 'text', 'textarea'];
        $qcfieldmultiples = ['checkbox', 'radio'];
        if( isset( $qckfields->type ) && in_array( $qckfields->type, $qcfieldsupports ) ) {
            $qcfieldtype = $qckfields->type;
        }
        ?>

       <div class="services-container">
          <div class="services-sub-container <?php echo !in_array( $qckfields->type, $qcfieldmultiples ) ? 'field-adjust' : ''; ?>">

            <?php if( isset( $qckfields->title ) ): ?>
             <div>
                <div class="services-title">
                   <label class="font-16 font-w-bold <?php echo isset($qckfields->type) ? $qckfields->type : ''; ?>"><?php echo $qckfields->title; ?></label>
                </div>
             </div>
             <?php endif; ?>


            <?php if( isset( $qckfields->fields ) && is_array( $qckfields->fields ) && in_array( $qckfields->type, $qcfieldmultiples ) ): ?>
            <div data-field="dynamic-field<?php echo $quickfielddynamicindexMain; ?>" data-custom-message="This field is required.">
            <?php

               $thefieldchunked = array_chunk( $qckfields->fields, 3 );
               foreach( $thefieldchunked as $qfieldchuinked):
               ?>
             <div class="grid grid-template-4-12">

               <?php 
               foreach( $qfieldchuinked as $getfieldquickform ):
               ?>
                <div class="services-boxes">
                   <div class="mb-10">
                      <label class="pointer font-w-100"> 
                        <input type="<?php echo $qcfieldtype ?>" name="dynamic-field<?php echo $quickfielddynamicindexMain; ?>" value="<?php echo $getfieldquickform; ?>">
                        <?php echo $getfieldquickform; ?>
                      </label>
                   </div>
                </div>
                <?php endforeach; ?>

             </div>
             <?php endforeach; ?>
            </div>
            

             <?php else: ?>

                <?php if( $qckfields->type == 'text' ): ?>
                    <input type="text" name="dynamic-field<?php echo $quickfielddynamicindexMain; ?>" data-field="dynamic-field<?php echo $quickfielddynamicindexMain; ?>" data-custom-message="This field is required.">
                <?php elseif( $qckfields->type == 'textarea' ): ?>
                    <textarea rows="4" name="dynamic-field<?php echo $quickfielddynamicindexMain; ?>" data-field="dynamic-field<?php echo $quickfielddynamicindexMain; ?>" data-custom-message="This field is required."></textarea>
                <?php endif; ?>

             <?php endif; ?>
            

          </div>
       </div>
       <?php $quickfielddynamicindexMain++; endforeach; ?>


      </div>
    </div>
    <?php endif; ?>

    <div class="field-file field">
        <div class="">
            <label>Upload Files and/or Photos Here</label>
            <div class="i-container drag-drop-files">
                <div class="file-upload-content text-center" style="padding: 25px;">
                    <p class="file-text">Drop files here or</p>
                    <p class="file-button middle-center">Select Files</p>
                    <input type="file" id="file" class="file hidden" multiple placeholder="Select" max-size="5000" data-quickformcontact-files>
                </div>
            </div>
            <label>Max. file size: 5 GB.</label>
            
            <div data-progresslists style="margin: 20px 0;"></div>

        </div>
    </div>
    
	<div class="field-consent field" style="margin-bottom: 10px;">
        <label>Consent</label>
        <div class="mb-10">
            <label for="consent" class="cursor-pointer font-w-100 cursor-pointer"><input type="checkbox" id="consent" name="terms" value="1"> I have read and agree to terms & conditions</label><span class="br"></span>
        </div>

        <a href="<?php echo carbon_get_theme_option('ponds_terms_url'); ?>" target="_blank" class="terms-services" data-field="terms" data-custom-message="You must agree to terms and conditions.">
            <p>Please Review Our Terms & Conditions</p>
        </a>
    </div>
    
    <?php if(carbon_get_theme_option('ponds_recaptcha_sitekey')): ?>
    <div class="g-recaptcha" data-field="g-recaptcha-response" data-custom-message="Please confirm if you are not a robot." style="margin: 20px 0;" data-sitekey="<?php echo carbon_get_theme_option('ponds_recaptcha_sitekey'); ?>"></div>
    <?php endif; ?>

    <div class="field-submit field">
        <div class="message-container">
            <input class="button" type="submit" name="submit" value="Submit" data-text="Submit" data-btn-submit>
        </div>
    </div>
</form>