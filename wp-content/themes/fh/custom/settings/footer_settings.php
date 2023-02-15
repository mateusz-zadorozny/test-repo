<?php
$theme_dir = get_template_directory();
require_once $theme_dir . '/custom/helpers/meta_boxes.php';

add_filter( 'mb_settings_pages', 'footer_settings' );

function footer_settings( $settings_pages ) {
	$settings_pages[] = [
        'menu_title' => __( 'Footer Settings', 'footer_settings' ),
        'id'         => 'footer-settings',
        'position'   => 1,
        'style'      => 'no-boxes',
        'columns'    => 1,
        'icon_url'   => 'dashicons-admin-generic',
    ];

	return $settings_pages;
}

add_filter( 'rwmb_meta_boxes', 'form_short_code_function' );


function form_short_code_function( $meta_boxes ) {
    $prefix = '';
    
    $mb = [
            'title'          => __( 'Form short code %LANG%', 'form_short_code_%LANG%' ),
            'id'             => 'form-short-code_%LANG%',
            'settings_pages' => ['footer-settings'],
            'fields'         => [
                [
                    'name' => __( 'Form short code %LANG%', 'form_short_code_%LANG%' ),
                    'id'   => $prefix . 'form_short_code_%LANG%',
                    'type' => 'text',
                ],
            ],
        ];
    
    generate_meta_boxes_custom_fields_by_laguages($mb, $meta_boxes);
    return $meta_boxes;
}


add_filter( 'rwmb_meta_boxes', 'legal_pages_options' );

function legal_pages_options( $meta_boxes ) {
    $prefix = '';

    $mb = [
        'title'          => __( 'Terms and conditions page %LANG%', 'terms-and-conditions-%LANG%' ),
        'settings_pages' => ['footer-settings'],
        'fields'         => [
            [
                'name'      => __( 'Terms and conditions page %LANG%', 'terms-and-conditions-page-%LANG%' ),
                'id'        => $prefix . 'terms_and_conditions_page_%LANG%',
                'type'      => 'post',
                'post_type' => ['page'],
            ],
        ],
    ];

    generate_meta_boxes_custom_fields_by_laguages($mb, $meta_boxes);
    
    $mb = [
        'title'          => __( 'Privacy policy page %LANG%', 'privacy-policy-%LANG%' ),
        'settings_pages' => ['footer-settings'],
        'fields'         => [
            [
                'name'      => __( 'Privacy policy page %LANG%', 'privacy-policy-page-%LANG%' ),
                'id'        => $prefix . 'privacy_policy_page_%LANG%',
                'type'      => 'post',
                'post_type' => ['page'],
            ],
        ],
    ];

    generate_meta_boxes_custom_fields_by_laguages($mb, $meta_boxes);
    
    return $meta_boxes;
}
