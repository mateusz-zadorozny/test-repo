<?php $post = get_query_var('item'); ?>

<div class="col-lg-4 col-12 col-sm-6 mb-4 mb-lg-5 post-card__hover">
    <a href="<?= $post->link; ?>" class="post-card">
        <?php if (!empty($post->thumbnail)): ?>
            <figure class="post-image-wrapper">
                <img class="post-image" src="<?= $post->thumbnail ?>" />
            </figure>
        <?php endif; ?>
        <div class="post-info py-2">
            <?php if (isset($post->category)): ?>
                <p class="m-0 category-badge">
                    <?= $post->category[0]->name; ?>
                </p>
            <?php endif; ?>
            <h3><?= $post->title; ?></h3>
            <p class="read-more mt-2 d-md-none"><?= pll_e('Read more') ?> <i class="icon-arrow-right"></i></p>
            
        </div>
    </a>

</div>
