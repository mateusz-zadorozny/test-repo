<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$buyViaStripe = rwmb_meta( 'buy_via_stripe', ['object_type' => 'setting'], 'products-settings' );
$buyViaWoocommerce = rwmb_meta( 'buy_via_woocommerce', ['object_type' => 'setting'], 'products-settings' );
$findAnInstallerLink = rwmb_meta( 'find_an_installer_'. (pll_current_language()), ['object_type' => 'setting'], 'products-settings' );

$status = isset($_GET['status']) ? $_GET['status'] : null;
if (strtoupper($status) === 'OK') :
    $title = rwmb_meta( 'stripe_success_message_title_' . (pll_current_language()), ['object_type' => 'setting'], 'products-settings' );
    $content = rwmb_meta( 'stripe_success_message_content_' . (pll_current_language()), ['object_type' => 'setting'], 'products-settings' );
    $class = 'success';
elseif ($status !== null) : 
    $title = rwmb_meta( 'stripe_error_message_title_' . (pll_current_language()), ['object_type' => 'setting'], 'products-settings' );
    $content = rwmb_meta( 'stripe_error_message_content_' . (pll_current_language()), ['object_type' => 'setting'], 'products-settings' );
    $class = 'error';
    ?>

<?php endif; 

get_header('shop');

$stripeBackUrl = get_permalink();
$form = "["
            . "wp_stripe_checkout_session name='{$product->get_name()}' "
            . " price='{$product->get_price()}'"
            . " billing_address='required'"
            . " success_url='{$stripeBackUrl}?status=ok'"
            . " cancel_url='{$stripeBackUrl}?status=error'"
        . "]";

if ($status !== null):
?>
<div class="info-box <?= $class; ?>">
    <div class="icon"></div>
    <div class="info-box-content">
        <p class="h4"><?= $title; ?></p>
        <p><?= $content; ?></p>
    </div>
    <button class="close">×</button>
</div>
<?php
endif;
?>

<section class="wp-block-create-block-main-slider product-intro p-0">
    <div class="page-intro intro_content_type">
        <div class="intro-slider">
            <div class="main-slider__item intro-slide subpage">
            <?php 
                $secondThumbnail = getSecondThumbnail($product->ID);
                if ($secondThumbnail):
            ?>
            <figure class="intro-background-image product">
                <img src="<?= $secondThumbnail[0]["full"] ?>" />
            </figure>
            <?php endif; ?>
            <div class="intro-content">
                <div class="row">
                    <div class="shape-content col-6">
                        <div class="breadcrumbs mb-2 white">
                            <?php woocommerce_breadcrumb(array('delimiter' => '&nbsp; &#8250; &nbsp; ')); ?>
                        </div>
                        <h1 class="mb-1"><?= $product->get_name(); ?></h1>
                        <p class="price h3 mb-3">
                            <?=
                            // Active formatted price: 
                            $product->get_price_html();

                            // Regular formatted  price: 
                            wc_price( wc_get_price_to_display( $product, array( 'price' => $product->get_regular_price() ) ) );

                            // Sale formatted  price: 
                            wc_price( wc_get_price_to_display( $product, array( 'price' => $product->get_sale_price() ) ) );
                            ?>
                        </p>
                        <div class="product-desc">
                            <?= $product->get_short_description(); ?>
                        </div>
                        <div class="d-flex mt-4 buttons-group">
                            <?php if ($buyViaWoocommerce) :
                            if ( $product->is_in_stock() ) : ?>

                            <?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

                                <form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
                                    <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

                                    <?php
                                    do_action( 'woocommerce_before_add_to_cart_quantity' );

                                    woocommerce_quantity_input(
                                            array(
                                                    'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
                                                    'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
                                                    'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
                                            )
                                    );

                                    do_action( 'woocommerce_after_add_to_cart_quantity' );
                                    ?>

                                    <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" 
                                            class="button primary mr-4 mb-3 text-nowrap align-items-center d-flex">
                                                <?= pll_e('Buy now') ?>
                                    </button>

                                    <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
                                </form>

                                <?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

                            <?php endif; ?>
                                
                          
                            <?php elseif ($buyViaStripe): ?>
                                <a href="#" class="button primary mr-4 mb-3 text-nowrap align-items-center d-flex buy-by-stripe"><span><?= pll_e('Buy now') ?></span></a>
                            <?php else:?>
                                <a href="#buy-via-partner" class="button primary mr-4 mb-3 text-nowrap align-items-center d-flex"><span><?= pll_e('Buy via partner') ?></span></a>
                            <?php endif;?>
                            <?php if (!empty($findAnInstallerLink)) :?> 
                                <a href="<?=$findAnInstallerLink;?>" class="button ghost mb-3"><?= pll_e('Find an installer') ?></a>
                            <?php endif;?>
                        </div>
                        <?php if ($buyViaStripe) :?>
                        <div class="stripe-form" hidden>
                           <?= do_shortcode($form); ?>
                        </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="fixed-action-bar py-3">
    <div class="row">
        <div class="product-summary col">
            <p class="h3 mb-0"><?= $product->get_name(); ?></p>
            <span class="product-price">
                <?=
                    // Active formatted price: 
                    $product->get_price_html();

                    // Regular formatted  price: 
                    wc_price( wc_get_price_to_display( $product, array( 'price' => $product->get_regular_price() ) ) );

                    // Sale formatted  price: 
                    wc_price( wc_get_price_to_display( $product, array( 'price' => $product->get_sale_price() ) ) );
                ?>
            </span>
        </div>
        <div class="col">
            <div class="d-flex buttons-group">
                <?php if ($buyViaWoocommerce) :
                    if ( $product->is_in_stock() ) : ?>

                    <?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

                        <form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
                            <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

                            <?php
                            do_action( 'woocommerce_before_add_to_cart_quantity' );

                            woocommerce_quantity_input(
                                    array(
                                            'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
                                            'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
                                            'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
                                    )
                            );

                            do_action( 'woocommerce_after_add_to_cart_quantity' );
                            ?>

                            <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" 
                                    class="button primary mr-4 mb-3 text-nowrap align-items-center d-flex">
                                        <?= pll_e('Buy now') ?>
                            </button>

                            <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
                        </form>

                        <?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

                    <?php endif; ?>


                <?php elseif ($buyViaStripe): ?>
                    <a href="#" class="button primary mr-4 text-nowrap align-items-center d-flex buy-by-stripe"><span><?= pll_e('Buy now') ?></span></a>
                <?php else:?>
                    <a href="#buy-via-partner" class="button primary mr-4 text-nowrap align-items-center d-flex"><span><?= pll_e('Buy via partner') ?></span></a>
                <?php endif;?>
                <?php if (!empty($findAnInstallerLink)) :?> 
                    <a href="<?=$findAnInstallerLink;?>" class="button ghost black"><?= pll_e('Find an installer') ?></a>
                <?php endif;?>
            </div>
        </div>
    </div>
</section>

<?php while ( have_posts() ) : ?>
    <?php the_post(); ?>

    <?php wc_get_template_part( 'content', 'single-product' ); ?>

<?php endwhile; // end of the loop. ?>

<?php
    /**
     * woocommerce_after_main_content hook.
     *
     * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
     */
    do_action( 'woocommerce_after_main_content' );
?>

<?php
get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
