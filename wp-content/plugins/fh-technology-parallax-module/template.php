<section class="technology-parallax-module" <?php echo wp_kses_data(get_block_wrapper_attributes()); ?> style="background-image: url(<?= plugin_dir_url(__FILE__) . '/assets/technology-parallax-bg.jpg'; ?>);" >
    <div class="container technology-parallax-module__container layer-above">
        <div class="technology-parallax-module__row left row">
            <div class="col-sm-12 col-lg-4 col-xl-3 technology-parallax-module__content">
                <?php if (!empty($attributes['sectionOneTitle'])): ?>
                    <h2><?= $attributes['sectionOneTitle'] ?></h2>
                <?php endif; ?>
                <?php if (!empty($attributes['sectionOneContent'])): ?>
                    <p class="medium"><?= $attributes['sectionOneContent'] ?></p>
                <?php endif; ?>
            </div>
            <div class="col-sm-12 col-lg-8 offset-xl-1">
                <figure class="technology-parallax-module__img add-lines bottom">
                    <img class="technology-parallax-module__img--front" src="<?= plugin_dir_url(__FILE__) . '/assets/technology-smarthub-top.png'; ?>" alt="Smarthub Model"/>
                </figure>
            </div>
        </div>
    </div>
    <div class="container technology-parallax-module__container">
        <div class="technology-parallax-module__row right row ">
            <div class="col-sm-12 col-lg-5 order-lg-2 technology-parallax-module__content ps-lg-5">
                <?php if (!empty($attributes['sectionTwoTitle'])): ?>
                    <h2><?= $attributes['sectionTwoTitle'] ?></h2>
                <?php endif; ?>
                <?php if (!empty($attributes['sectionTwoContent'])): ?>
                    <p class="medium"><?= $attributes['sectionTwoContent'] ?></p>
                <?php endif; ?>
            </div>
            <div class="col-sm-12 col-lg-7 order-lg-1">
                <figure class="technology-parallax-module__img">
                    <img class="technology-parallax-module__img--front" src="<?= plugin_dir_url(__FILE__) . '/assets/technology-smarthub-design-module.png'; ?>" alt="Smarthub Model"/>
                    <img class="technology-parallax-module__img--mask left-bottom wide" src="<?= plugin_dir_url(__FILE__) . '/assets/gradient-shape-blue-grey.svg'; ?>" alt="Background element"/>
                </figure>
            </div>
        </div>
    </div>
    <div class="container technology-parallax-module__container third">
        <div class="technology-parallax-module__row left row align-items-end">
            <div class="col-sm-12 col-lg-7 technology-parallax-module__content">
                <?php if (!empty($attributes['sectionThreeTitle'])): ?>
                    <h2><?= $attributes['sectionThreeTitle'] ?></h2>
                <?php endif; ?>
                <?php if (!empty($attributes['sectionThreeContent'])): ?>
                    <p class="large"><?= $attributes['sectionThreeContent'] ?></p>
                <?php endif; ?>
            </div>
            <div class="col-sm-12 col-lg-4 offset-lg-1">
                <figure class="technology-parallax-module__img">
                    <img class="technology-parallax-module__img--front" src="<?= plugin_dir_url(__FILE__) . '/assets/technology-board.png'; ?>" alt="Smarthub Board"/>
                    <img class="technology-parallax-module__img--mask right-bottom" src="<?= plugin_dir_url(__FILE__) . '/assets/gradient-shape-blue-grey-2.svg'; ?>" alt="Background element"/>
                </figure>
            </div>
        </div>
    </div>
    <div class="container technology-parallax-module__container">
        <div class="technology-parallax-module__row image-columns row">
            <div class="col-sm-6 col-lg-4 technology-parallax-module__column">
                <figure class="technology-parallax-module__column-img">
                    <img class="technology-parallax-module__column-img--front" src="<?= plugin_dir_url(__FILE__) . '/assets/technology-faster-processing.png'; ?>" alt="2x Faster Processing"/>
                </figure>
                <?php if (!empty($attributes['sectionColumnsOneTitle'])): ?>
                    <h2 class="technology-parallax-module__column--title"><?= $attributes['sectionColumnsOneTitle'] ?></h2>
                <?php endif; ?>
                <?php if (!empty($attributes['sectionColumnsOneContent'])): ?>
                    <p class="medium"><?= $attributes['sectionColumnsOneContent'] ?></p>
                <?php endif; ?>
            </div>
            <div class="col-sm-6 col-lg-4 technology-parallax-module__column">
                <figure class="technology-parallax-module__column-img">
                    <img class="technology-parallax-module__column-img--front" src="<?= plugin_dir_url(__FILE__) . '/assets/technology-2x-storage.jpg'; ?>" alt="2x Storage"/>
                </figure>
                <?php if (!empty($attributes['sectionColumnsTwoTitle'])): ?>
                    <h2 class="technology-parallax-module__column--title"><?= $attributes['sectionColumnsTwoTitle'] ?></h2>
                <?php endif; ?>
                <?php if (!empty($attributes['sectionColumnsTwoContent'])): ?>
                    <p class="medium"><?= $attributes['sectionColumnsTwoContent'] ?></p>
                <?php endif; ?>
            </div>
            <div class="col-sm-6 col-lg-4 technology-parallax-module__column">
                <figure class="technology-parallax-module__column-img">
                    <img class="technology-parallax-module__column-img--front" src="<?= plugin_dir_url(__FILE__) . '/assets/technology-faster-processing.png'; ?>" alt="Encrypted communication"/>
                </figure>
                <?php if (!empty($attributes['sectionColumnsThreeTitle'])): ?>
                    <h2 class="technology-parallax-module__column--title"><?= $attributes['sectionColumnsThreeTitle'] ?></h2>
                <?php endif; ?>
                <?php if (!empty($attributes['sectionColumnsThreeContent'])): ?>
                    <p class="medium"><?= $attributes['sectionColumnsThreeContent'] ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="container technology-parallax-module__container">
        <div class="technology-parallax-module__row left row">
            <div class="col-sm-12 col-lg-4 technology-parallax-module__content">
                <?php if (!empty($attributes['sectionFourTitle'])): ?>
                    <h2><?= $attributes['sectionFourTitle'] ?></h2>
                <?php endif; ?>
                <?php if (!empty($attributes['sectionFourContent'])): ?>
                    <p class="medium"><?= $attributes['sectionFourContent'] ?></p>
                <?php endif; ?>
            </div>
            <div class="col-sm-12 col-lg-7 offset-lg-1">
                <figure class="technology-parallax-module__img add-lines left">
                    <img class="technology-parallax-module__img--front"  src="<?= plugin_dir_url(__FILE__) . '/assets/technology-expansion.png'; ?>" alt="Smarthub Model"/>
                    <img class="technology-parallax-module__img--mask left-bottom" src="<?= plugin_dir_url(__FILE__) . '/assets/gradient-shape-blue-grey-3.svg'; ?>" alt="Background element"/>
                </figure>
            </div>
        </div>
    </div>
    <div class="container technology-parallax-module__container d-none">
        <div class="technology-parallax-module__row left row">
            <div class="col-sm-12 col-lg-4 offset-lg-1 technology-parallax-module__content order-lg-2">
                <?php if (!empty($attributes['sectionFiveTitle'])): ?>
                    <h2><?= $attributes['sectionFiveTitle'] ?></h2>
                <?php endif; ?>
                <?php if (!empty($attributes['sectionFiveContent'])): ?>
                    <p class="medium"><?= $attributes['sectionFiveContent'] ?></p>
                <?php endif; ?>
            </div>
            <div class="col-sm-12 col-lg-5 order-lg-1">
                <figure class="technology-parallax-module__img add-lines last">
                    <img class="technology-parallax-module__img--front" src="<?= plugin_dir_url(__FILE__) . '/assets/technology-smarthub-double-model.png'; ?>" alt="Smarthub Model"/>
                    <img class="technology-parallax-module__img--mask right-bottom" src="<?= plugin_dir_url(__FILE__) . '/assets/gradient-shape-blue-grey-2.svg'; ?>" alt="Background element"/>
                </figure>
            </div>
        </div>
    </div>
</section>


<script>
    jQuery(document).ready(function() {
    //parallax scroll
        jQuery(window).on("load scroll", function() {
            var parallaxElementFront = jQuery(".technology-parallax-module__img--front"),
            parallaxElementBack = jQuery(".technology-parallax-module__img--mask"),
            parallaxFrontTranslate = 0.15,
            parallaxBackTranslate = 0.05,
            parallaxFrontQuantity = parallaxElementFront.length;
            parallaxBackQuantity = parallaxElementBack.length;
            window.requestAnimationFrame(function() {
                for (var i = 0; i < parallaxFrontQuantity; i++) {
                    var currentElement = parallaxElementFront.eq(i),
                    windowTop = jQuery(window).scrollTop(),
                    elementTop = currentElement.offset().top,
                    elementHeight = currentElement.height(),
                    viewPortHeight = window.innerHeight * 0.5 - elementHeight * 0.5,
                    scrolled = windowTop - elementTop + viewPortHeight;
                    currentElement.css({
                        transform: "translate3d(0," + scrolled * -parallaxFrontTranslate + "px, 0)"
                    });
                }
                for (var i = 0; i < parallaxBackQuantity; i++) {
                    var currentElement = parallaxElementBack.eq(i),
                    windowTop = jQuery(window).scrollTop(),
                    elementTop = currentElement.offset().top,
                    elementHeight = currentElement.height(),
                    viewPortHeight = window.innerHeight * 0.5 - elementHeight * 0.5,
                    scrolled = windowTop - elementTop + viewPortHeight;
                    currentElement.css({
                        transform: "translate3d(0," + scrolled * -parallaxBackTranslate + "px, 0)"
                    });
                }
            });
        });
    });
</script>