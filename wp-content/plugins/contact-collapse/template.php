<?php
/**
 * All of the parameters passed to the function where this file is being required are accessible in this scope:
 *
 * @param array    $attributes     The array of attributes for this block.
 * @param string   $content        Rendered block output. ie. <InnerBlocks.Content />.
 * @param WP_Block $block_instance The instance of the WP_Block class that represents the block being rendered.
 *
 * @package gutenberg-examples
 */


$columnsVariant = $attributes['columnsVariant'];

if ($columnsVariant === "4/8") {
	if ($attributes['sidebarBackgroundColor'] === 'white-bg'){
		$columnClass1 = 'col-sm-12 col-xl-4 mb-2 mb-xl-0 pe-xl-5';
		$columnClass2 = 'col-sm-12 col-xl-8';
	} else {
		$columnClass1 = 'col-sm-12 col-xl-3 mb-5 mb-xl-0';
		$columnClass2 = 'col-sm-12 col-xl-8 offset-xl-1';
	}
} else if ($columnsVariant === "8/4") {
	$columnClass1 = 'col-sm-12 col-lg-7 mb-5';
	$columnClass2 = 'col-sm-12 col-lg-5 d-flex justify-content-end';
} else if ($columnsVariant === "6/6") {
	$columnClass1 = 'col-lg-6';
	$columnClass2 = 'col-lg-6';
}

?>

<section class="wp-block-create-block-contact-collapse" <?php echo wp_kses_data(get_block_wrapper_attributes()); ?>>
	<div class="container">
		<div class="row">
			<div class="<?= $columnClass1 ?>">
				<div class="contact-collapse-main-content">
					<?php if (!empty($attributes['title'])): ?>
						<h2 class="contact-collapse-main-title">
							<?php echo wp_kses_post($attributes['title']); ?>
						</h2>
					<?php endif; ?>
					<?php if (!empty($attributes['content'])): ?>
						<p>
							<?php echo wp_kses_post($attributes['content']); ?>
						</p>
					<?php endif; ?>
				</div>
				<div class="contact-collapse">
					<?php
                        if (!empty($attributes['contactBlocks'])):
	                        foreach ($attributes['contactBlocks'] as $block):
                        ?>
					<div class="contact-collapse__item">
						<div class="contact-collapse__item-main">
							<div>
								<h3 class="mb-2">
									<?php echo wp_kses_post($block['title']); ?>
								</h3>
								<p>
									<?php echo wp_kses_post($block['description']); ?>
								</p>
							</div>
							<span class="contact-collapse__item-icon">
								<i class="icon-chevron-bottom"></i>
							</span>
						</div>
						<div class="contact-collapse__item-content">
							<hr />
							<div class="collapse__item-content">
								<?php if (isset($block['contacts']) && !empty($block['contacts'])):
			                        foreach ($block['contacts'] as $contact):
                                            ?>
								<div class="collapse__item-content--box">
									<p class="collapse__item-content--title">
										<?php echo wp_kses_post($contact['name']); ?>
									</p>
									<p class="collapse__item-content--text">
										<?php echo wp_kses_post($contact['email']); ?>
									</p>
									<p class="collapse__item-content--text">
										<?php echo wp_kses_post($contact['phone']); ?>
									</p>
								</div>

								<?php
			                        endforeach;
		                        endif;
                                            ?>
							</div>
						</div>
					</div>
					<?php
	                        endforeach;
                        endif;
                        ?>
				</div>
				<?php if (!empty($attributes['socialMediaTitle']) && (!empty($attributes['socialLinks']))): ?>
					<div class="social-media mt-5">
						<?php if (!empty($attributes['socialMediaTitle'])): ?>
							<h3 class="mb-0"><?= $attributes['socialMediaTitle']; ?></h3>
						<?php endif; ?>
						<?php if(!empty($attributes['socialLinks'])): ?>
							<ul class="socials-list">
								<?php foreach($attributes['socialLinks'] as $socialItem):?>
									<li class="social-media-link__item">
										<a class="social-media-link__item-main" href="<?php echo wp_kses_post($socialItem['socialURL']) ?>">
											<?php if (!empty($socialItem['iconImage']['url'])): ?>
												<figure class="social-media-link__img-wrapper">
													<img class="social-media-banner__img-src" src="<?php echo wp_kses_post($socialItem['iconImage']['url']) ?>" alt="Social icon" />
												</figure>
											<?php endif; ?>
											<span class="social-media-link__item-title"><?php echo wp_kses_post($socialItem['title']) ?></span>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>
				<?php endif; ?>

			</div>
			<div class="mb-auto <?= $columnClass2 ?>">
				<div class="sidebar <?= $attributes['sidebarBackgroundColor']; ?>">
					<?php if ($attributes['sidebarBackgroundColor'] == 'white-bg'): ?>
						<?php if (!empty($attributes['formShortCode'])): ?>
							<p class="medium sidebar-intro">
								<?= $attributes['sidebarTitle']; ?>
							</p>
						<?php endif; ?>
					<?php else: ?>
						<?php if (!empty($attributes['formShortCode'])): ?>
							<h2 class="sidebar-title">
								<?= $attributes['sidebarTitle']; ?>
							</h2>
						<?php endif; ?>
					<?php endif; ?>
					<?php if (!empty($attributes['formShortCode'])): ?>
						<?= $attributes['formShortCode']; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>