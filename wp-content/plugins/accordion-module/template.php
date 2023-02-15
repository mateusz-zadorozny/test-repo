<?php 
$blockClass = get_block_wrapper_attributes([
    'class' => 'accordion-module' 
]);
$faqItems = $attributes['items'];
?>

<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
    <?php foreach ($faqItems as $key => $item): ?>
        {
            "@type": "Question",
            "name": "<?= wp_kses_post($item['title']); ?>",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "<p><?= wp_kses_post($item['content']); ?></p>"
            }
        }<?= ($key === array_key_last($faqItems)) ? "" : "," ?>
    <?php endforeach; ?>
    ]
}
</script>

<section <?= $blockClass ?> >
    <div class="container">
        <div class="row">
            <div class="col-12 col-xl-3 mb-5 mb-xl-0">
                <div>
                    <?php if (!empty($attributes['title'])): ?>
                    <h2 class="accordion-module__header">
                        <?= wp_kses_post($attributes['title']); ?>
                    </h2>
                    <?php endif; ?>
                    <?php if (!empty($attributes['content'])): ?>
                    <p class="accordion-module__text">
                        <?= wp_kses_post($attributes['content']); ?>
                    </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-12 col-xl-8 offset-xl-1">
                <?php if (count($attributes['items']) > 0): ?>
                <div class="accordion">
                    <?php $i = 0; ?>
                    <?php foreach ($attributes['items'] as $item) :?>
                        <?php $i++; ?>
                        <div class="accordion__item toggle">
                            <?php if (!empty($item['title'])): ?>
                            <div class="accordion__item-main">
                                <?= wp_kses_post($item['title']); ?>
                                <span class="accordion__item-icon">
                                    <i class="icon-chevron-bottom"></i>
                                </span>
                            </div>
                            <?php endif;?>
                            <?php if (!empty($attributes['content'])): ?>
                            <p class="accordion__item-content toggle-content">
                                <?= wp_kses_post($item['content']); ?>
                            </p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach;?>
                </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</section>

