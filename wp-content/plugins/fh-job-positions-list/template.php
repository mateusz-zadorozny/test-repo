<?php 
    list($categories, $localizations, $jobs) = prepare_data_to_job_positions_list($attributes);

?>

<section class="wp-block-create-block-open-positions-section" <?php echo wp_kses_data(get_block_wrapper_attributes()); ?>>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-3">
                <div class="open-positions__content-box">
                    <?php if (!empty($attributes['title'])): ?>
                        <h2 class="open-positions__header">
                            <?php echo wp_kses_post($attributes['title']); ?>
                        </h2>
                    <?php endif; ?>
                    <?php if (!empty($attributes['content'])): ?>
                        <p class="social__text">
                            <?php echo wp_kses_post($attributes['content']); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-12 col-lg-8 offset-lg-1">
                <div class="open-positions-selectBox">
                    <form class="d-flex flex-wrap justify-content-between w-100" method="get">
                        <?php if (count($categories) > 0) :?>
                        <div class="col-sm-12 col-lg-6 flex-column d-flex selectBox-item">
                            <select class="select2" name="job_position_list_categories">
                                <option value="-"><?= __('All categories', 'job-positions-all-categories') ?></option>
                                <?php foreach ($categories as $cat) : ?>
                                <option value="<?=$cat->term_id;?>"><?=$cat->name;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <?php endif;?>
                        <?php if (count($localizations) > 0) :?>
                        <div class="col-sm-12 col-lg-6 flex-column d-flex selectBox-item">
                            <select class="select2" name="job_position_list_localizations" data-placeholder="placeholder">
                                <option value="-"><?= __('All localizations', 'job-positions-all-localizations') ?></option>
                                <?php foreach ($localizations as $cat) : ?>
                                    <option value="<?=$cat->term_id;?>"><?=$cat->name;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <?php endif;?>
                    </form>
                </div>
                <div class="open-positions-banner">
                    <?php foreach ($jobs as $job) :?>
                        <?php echo render_singel_job_item($job);?>
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    </div>
</section>