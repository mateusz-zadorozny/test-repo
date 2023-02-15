<section class="partners-module" id="buy-via-partner" <?php echo wp_kses_data(get_block_wrapper_attributes()); ?>>
    <div class="container">
        <div class="row">
            <div class="col-12 col-xl-3 mb-5 mb-xl-0">
                <h2> <?php echo wp_kses_post($attributes['title']); ?> </h2>
            </div>
            <div class="col-12 col-xl-8 offset-xl-1 partners-list">
                <?php if(count($attributes['partnersList'] > 0)): ?>
                    <?php foreach($attributes['partnersList'] as $partner): 
                        $partnerObj = getPartnerData($partner['partnerId']);
                        $logo = rwmb_meta('logo', null, $partnerObj->ID);
                        $img = $logo['url'];
                        $link = rwmb_meta('url', null, $partnerObj->ID);
                        
                        $partnerLink = !empty($partner['link']) ? $partner['link'] : $link;
                        ?>
                        <div class="partner-block">
                            <div class="partner-block__brand">
                                <img src="<?php echo $img?>" alt="">
                                <h3 class="h2"><?php echo $partnerObj->post_title?></h3>
                            </div>
                            <div class="partner-block__description">
                                <p><?php echo rwmb_meta('description', null, $partnerObj->ID);?></p>
                            </div>
                            <div class="partner-block__button">
                                <a href="<?php echo strpos($partnerLink, 'http') === 0 ? wp_kses_post($partnerLink) : wp_kses_post("//".$partnerLink)?>" target='blank' rel="nofollow" class="button secondary">
                                    <?= pll_e('Visit partner'); ?>
                                </a>
                            </div>
                        </div>
    
                    <?php endforeach ?>
                <?php endif ?>
            </div>
        </div>
    </div>


</section>