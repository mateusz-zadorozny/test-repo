<section class="container post-main">
    <div class="row">
        <div class="col-lg-6 col-xl-7">
            <div class="job-description-intro">
                <?= rwmb_meta('job_description'); ?>
            </div>
            <div class="job-salary box">
                <?= pll_e( 'Pay scales' );?>
                <div class="job-salary-content">
                    <p>
                        <strong><?= rwmb_meta('pay_scale_amount'); ?></strong> <?= rwmb_meta('pay_scale_info'); ?>
                    </p>
                </div>
            </div>
            <div class="social-share-inline">
                <?= pll_e( 'Share on your social media' );?>
                <button class="social-share-button social-share-fb" data-href="<?php the_permalink() ?>">
                    <i class="icon-facebook"></i>

                </button>
                <?= pll_e( 'or' );?>
                <button class="social-share-button social-share-linkedin" data-href="<?php the_permalink() ?>">
                    <i class="icon-linkedin"></i>
                </button>
            </div>
            <?= the_content() ?>
        </div>
        <div class="col-lg-6 col-xl-5 sidebar-col">
            <div class="sidebar">
                <h2 class="mt-0"><?= rwmb_meta('form_title'); ?></h2>
                <?= do_shortcode(rwmb_meta('form_short_code')); ?>
            </div>
        </div>
    </div>
</section>

<section class="white-bg wp-block-create-block-icons-columns">
    <div class="container section-visible">
        <div class="icons-columns">
            <div class="row">
                <div class="col-12 col-xl-3 mb-4 mb-xl-0">
                    <div class="icons-columns__content-box">
                        <h2 class="icons-columns__header"><?= rwmb_meta('job_benefits_title'); ?></h2>
                    </div>
                </div>
                <div class="col-12 col-xl-8 offset-xl-1 pt-2">
                <?php
                    $group1 = rwmb_meta('job_benefits_group_1');
                    $group2 = rwmb_meta('job_benefits_group_2');
                    $group3 = rwmb_meta('job_benefits_group_3');
                    ?>
                    <div class="icons-columns__row row">
                        <div class="icons-columns__card col-12 col-sm-6 col-lg-4 mb-4 pe-lg-4">
                            <?php if (isset($group1['job_benefits_icon_1']) && !empty($group1['job_benefits_icon_1'])): ?>
                                <figure class="icons-columns__card-left">
                                    <img decoding="async" class="icons-columns__card-left--img"
                                        src="<?= wp_get_attachment_image_src($group1['job_benefits_icon_1'])[0]; ?>" alt="Icon">
                                </figure>
                            <?php endif; ?>
                            
                            <div class="icons-columns__card-right">
                                <?php if (isset($group1['job_benefits_title_1']) && !empty($group1['job_benefits_title_1'])): ?>
                                    <h3><?= $group1['job_benefits_title_1']; ?></h3>
                                <?php endif; ?>
                                <?php if (isset($group1['job_benefits_content_1']) && !empty($group1['job_benefits_content_1'])): ?>
                                    <p><?= $group1['job_benefits_content_1']; ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="icons-columns__card col-12 col-sm-6 col-lg-4 mb-4 pe-lg-4">
                            <?php if (isset($group2['job_benefits_icon_2']) && !empty($group2['job_benefits_icon_2'])): ?>
                                <figure class="icons-columns__card-left">
                                    <img decoding="async" class="icons-columns__card-left--img"
                                        src="<?= wp_get_attachment_image_src($group2['job_benefits_icon_2'])[0]; ?>" alt="Icon">
                                </figure>
                            <?php endif; ?>
                            
                            <div class="icons-columns__card-right">
                                <?php if (isset($group2['job_benefits_title_2']) && !empty($group2['job_benefits_title_2'])): ?>
                                    <h3><?= $group2['job_benefits_title_2']; ?></h3>
                                <?php endif; ?>
                                <?php if (isset($group2['job_benefits_content_2']) && !empty($group2['job_benefits_content_2'])): ?>
                                    <p><?= $group2['job_benefits_content_2']; ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="icons-columns__card col-12 col-sm-6 col-lg-4 mb-4 pe-lg-4">
                            <?php if (isset($group3['job_benefits_icon_3']) && !empty($group3['job_benefits_icon_3'])): ?>
                                <figure class="icons-columns__card-left">
                                    <img decoding="async" class="icons-columns__card-left--img"
                                        src="<?= wp_get_attachment_image_src($group3['job_benefits_icon_3'])[0]; ?>" alt="Icon">
                                </figure>
                            <?php endif; ?>
                            
                            <div class="icons-columns__card-right">
                                <?php if (isset($group3['job_benefits_title_3']) && !empty($group3['job_benefits_title_3'])): ?>
                                    <h3><?= $group3['job_benefits_title_3']; ?></h3>
                                <?php endif; ?>
                                <?php if (isset($group3['job_benefits_content_3']) && !empty($group3['job_benefits_content_3'])): ?>
                                    <p><?= $group3['job_benefits_content_3']; ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>