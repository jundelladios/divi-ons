<?php global $domainkey; ?>
<?php if(!$cs['membership_tb_hide_services']): ?>
<div class="our-services-popup-modal modalparent-our-services-<?php echo $cs['id']; ?>">
    <div class="close-modal-overlay bg-overlay-black has-custom-modal-close" data-modal-popup="our-services-<?php echo $cs['id']; ?>"></div>
    <div class="our-services-popup-sub-modal top-modal">
        <div class="close-x close-click has-custom-modal-close" data-modal-popup="our-services-<?php echo $cs['id']; ?>">
            <span></span>
            <span></span>
        </div>
        <div class="our-services-popup-sub-modal">
            <div class="our-services-popup-container">
                <div class="our-services-popup-main-title">
                    <h3>Our Services</h3>
                    <p>Below is our listed services.</p>
                    <p><a href="https://<?php echo $cs['domain']; ?>/<?php echo $cs['slug']; ?>/"><?php echo $cs['name']; ?></a></p>
                </div>

                <div class="our-services-popup-box-container">
                    <?php foreach($domainconfigs as $domainkey => $spagesdomain): ?>
                        <?php 
                        $filtereddomainspages = array_filter($cs['servicespageslists'], function ($sp) use ($domainkey) {
                            return ($sp->domain == $domainkey);
                        });
                        
                        if(count($filtereddomainspages)):
                        ?>
                        <div class="our-services-popup-box">
                            <div class="our-services-popup-box-title">
                                <h4><?php echo $spagesdomain['services_pages_title']; ?></h4>
                            </div>
                            <div class="our-services-popup-contents">
                                <?php foreach($filtereddomainspages as $customerspages): ?>
                                <p>
                                    <a class="text-capitalize" href="https://<?php echo $customerspages->domain; ?>/<?php echo $customerspages->slug; ?>/"> 
                                        <?php echo $customerspages->title; ?>
                                    </a>
                                </p>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php 
                        endif; 
                        ?>

                    <?php endforeach; ?>
                </div>


            </div>
        </div>
    </div>
</div>
<?php endif; ?>