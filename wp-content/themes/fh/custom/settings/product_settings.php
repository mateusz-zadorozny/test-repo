<?php
$theme_dir = get_template_directory();
require_once $theme_dir . '/custom/helpers/meta_boxes.php';

add_filter( 'rwmb_meta_boxes', 'custom_options' );

function custom_options( $meta_boxes ) {
    $prefix = '';

    $meta_boxes[] = [
        'title'      => __( 'Custom options', 'custom-options' ),
        'post_types' => ['page'],
        'fields'     => [
            [
                'name' => __( 'Is shop page', 'custom-options' ),
                'id'   => $prefix . 'is_shop_page',
                'type' => 'checkbox',
            ],
        ],
    ];

    return $meta_boxes;
}


add_filter( 'mb_settings_pages', 'products_settings' );

function products_settings( $settings_pages ) {
	$settings_pages[] = [
        'menu_title' => __( 'Products Settings', 'products_settings' ),
        'id'         => 'products-settings',
        'position'   => 1,
        'style'      => 'no-boxes',
        'columns'    => 1,
        'icon_url'   => 'dashicons-admin-generic',
    ];

	return $settings_pages;
}

add_filter( 'rwmb_meta_boxes', 'products_options' );

function products_options( $meta_boxes ) {
    $prefix = '';
    $meta_boxes[] = [
        'title'          => __( 'Settings', 'products-options' ),
        'settings_pages' => ['products-settings'],
        'fields'         => [
            [
                'name' => __( 'Buy via Stripe', 'buy-via-stripe' ),
                'id'   => $prefix . 'buy_via_stripe',
                'type' => 'checkbox'
            ],
            [
                'name' => __( 'Buy via Woocommerce', 'buy-via-woocommerce' ),
                'id'   => $prefix . 'buy_via_woocommerce',
                'type' => 'checkbox'
            ],
        ]
    ];
    
    $mb = [
        'title'          => __( 'Settings %LANG%', 'products-options-%LANG%' ),
        'settings_pages' => ['products-settings'],
        'fields'         => [
            [
                'name'      => __( 'Find an installer %LANG%', 'find-an-installer-%LANG%' ),
                'id'        => $prefix . 'find_an_installer_%LANG%',
                'type'      => 'text',
            ],
            [
                'name'      => __( 'Stripe success message title %LANG%', 'stripe-success-message-title-%LANG%' ),
                'id'        => $prefix . 'stripe_success_message_title_%LANG%',
                'type'      => 'textarea',
            ],
            [
                'name'      => __( 'Stripe success message content %LANG%', 'stripe-success-message-content-%LANG%' ),
                'id'        => $prefix . 'stripe_success_message_content_%LANG%',
                'type'      => 'textarea',
            ],
            [
                'name'      => __( 'Stripe error message title %LANG%', 'stripe-error-message-title-%LANG%' ),
                'id'        => $prefix . 'stripe_error_message_title_%LANG%',
                'type'      => 'textarea',
            ],
            [
                'name'      => __( 'Stripe error message content %LANG%', 'stripe-error-message-content-%LANG%' ),
                'id'        => $prefix . 'stripe_error_message_content_%LANG%',
                'type'      => 'textarea',
            ],
        ],
    ];

    generate_meta_boxes_custom_fields_by_laguages($mb, $meta_boxes);
    return $meta_boxes;
}
