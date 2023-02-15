<?php

add_filter( 'mb_settings_pages', 'odoo_sync_settings' );

function odoo_sync_settings( $settings_pages ) {
	$settings_pages[] = [
        'menu_title' => __( 'Odoo/WooCommerce Settings', 'odoo_sync_settings' ),
        'id'         => 'odoo_sync_settings',
        'position'   => 2,
        'style'      => 'no-boxes',
        'columns'    => 1,
        'icon_url'   => 'dashicons-admin-generic',
    ];

	return $settings_pages;
}

add_filter( 'rwmb_meta_boxes', 'odoo_settings_page_fields' );

function odoo_settings_page_fields( $meta_boxes ) {
    $prefix = '';

    $meta_boxes[] = [
        'title'          => __( 'Odoo sync custom fields', 'odoo_settings_page_fields' ),
        'settings_pages' => ['odoo_sync_settings'],
        'fields'         => [
            [
                'name'     => __( 'Odoo endpoint url', 'odoo_settings_page_fields' ),
                'id'       => $prefix . 'odoo_endpoint_url',
                'type'     => 'url',
                'required' => true,
            ],
            [
                'name'     => __( 'Pipedream url for copy', 'odoo_settings_page_fields' ),
                'id'       => $prefix . 'pipedream_url',
                'type'     => 'url',
                'required' => true,
            ],
            [
                'name' => __( 'Bearer token', 'odoo_settings_page_fields' ),
                'id'   => $prefix . 'bearer_token',
                'type' => 'text',
            ],
            [
                'name' => __( 'Shipping Internal Reference (Odoo)', 'odoo_settings_page_fields' ),
                'id'   => $prefix . 'shipping_internal',
                'type' => 'text',
            ],
        ],
    ];

    return $meta_boxes;
}

// add custom fields to the WooCommerce orders to save the Odoo response

add_filter( 'rwmb_meta_boxes', 'odoo_reference' );

function odoo_reference( $meta_boxes ) {
    $prefix = '';

    $meta_boxes[] = [
        'title'      => __( 'Orders', 'odoo_order_fields' ),
        'id'         => 'orders',
        'post_types' => ['shop_order'],
        'fields'     => [
            [
                'name'          => __( 'Odoo reference number', 'odoo_order_fields' ),
                'id'            => $prefix . 'odoo_reference',
                'type'          => 'text',
                'readonly'      => true,
                'admin_columns' => [
                    'position'   => 'after title',
                    'searchable' => true,
                ],
            ],
            [
                'name'     => __( 'Odoo raw answer', 'odoo_order_fields' ),
                'id'       => $prefix . 'odoo_raw_answer',
                'type'     => 'textarea',
                'readonly' => true,
            ],
        ],
    ];

    return $meta_boxes;
}