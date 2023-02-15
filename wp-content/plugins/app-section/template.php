<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<?php 
$blockClass = get_block_wrapper_attributes([
    'class' => $attributes['backgroundColor'] . ' appSection'  
]);
?>
<section <?= $blockClass ?> >
    <div class="container">
        <div class="row appSection__content">
            <div class="col-sm-12 col-lg-6 appSection__content-col">
                <div class="appSection__content-col--item">
                    <?php if (!empty($attributes['title'])): ?>
                    <h2 class="appSection__title">
                        <?= wp_kses_post($attributes['title']); ?>
                    </h2>
                    <?php endif; ?>
                    <?php if (!empty($attributes['subtitle'])): ?>
                    <p class="appSection__text">
                        <?= wp_kses_post($attributes['subtitle']); ?>
                    </p>
                    <?php endif; ?>
                    <div class="appSection__buttons">
                        <?php if (!empty($attributes['iosLink']) && !empty($attributes['iosLinkText'])): ?>
                            <a class="button secondary module-button module-button-icon me-2 mb-2 <?= (!empty($attributes['mobileIosLinkText'])) ? 'd-none d-sm-block' : ''?>" href="<?= $attributes['iosLink']; ?>">
                                <?= wp_kses_post($attributes['iosLinkText']); ?>
                                    <img class="module-button-icon-img" src="<?= plugin_dir_url(__FILE__) . '/assets/appStore.svg'; ?>" alt="icon" />
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($attributes['androidLink']) && !empty($attributes['androidLinkText'])): ?>
                            <a class="button secondary module-button-icon mb-2 <?= (!empty($attributes['mobileAndroidLinkText']))  ? 'd-none d-sm-block' : ''?>" href="<?= $attributes['androidLink']; ?>">
                                <?= wp_kses_post($attributes['androidLinkText']); ?>
                                    <img class="module-button-icon-img" src="<?= plugin_dir_url(__FILE__) . '/assets/googlePlay.svg'; ?>" alt="icon" />
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($attributes['iosLink']) && !empty($attributes['mobileIosLinkText'])): ?>
                            <a class="button secondary module-button module-button-icon me-2 mb-2 d-block d-sm-none" href="<?= $attributes['iosLink']; ?>">
                                <?= wp_kses_post($attributes['mobileIosLinkText']); ?>
                                    <img class="module-button-icon-img" src="<?= plugin_dir_url(__FILE__) . '/assets/appStore.svg'; ?>" alt="icon" />
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($attributes['androidLink']) && !empty($attributes['mobileAndroidLinkText'])): ?>
                            <a class="button secondary module-button-icon mb-2 d-block d-sm-none" href="<?= $attributes['androidLink']; ?>">
                                <?= wp_kses_post($attributes['mobileAndroidLinkText']); ?>
                                    <img class="module-button-icon-img" src="<?= plugin_dir_url(__FILE__) . '/assets/googlePlay.svg'; ?>" alt="icon" />
                            </a>
                        <?php endif; ?>
                    </div>
                    <img class="appSection__img-mobile"
                        src="<?= $attributes['backgroundImage']; ?>" alt="photo" />
                    <div class='appSection__support'>
                        <?php if (!empty($attributes['content'])): ?>
                        <p class="appSection__support-title">
                            <?= wp_kses_post($attributes['content']); ?>
                        </p>
                        <?php endif; ?>
                        <?php if (isset($attributes['icons']) && count($attributes['icons']) > 0): ?>
                        <div class="appSection__support-logos">
                            <?php foreach ($attributes['icons'] as $icon): ?>
                            <img class="appSection__support-logos--img" src="<?= $icon['url']; ?>" alt="icon" />
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php if (!empty($attributes['backgroundImage'])): ?>
            <div class="col-sm-12 col-lg-6 appSection__img-container">
                <img class="appSection__img img-fluid" src="<?= $attributes['backgroundImage']; ?>" alt="photo" />
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>