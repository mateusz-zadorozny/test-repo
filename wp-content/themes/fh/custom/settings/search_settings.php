<?php

$theme_dir = get_template_directory();
require_once $theme_dir . '/custom/helpers/meta_boxes.php';

add_filter( 'mb_settings_pages', 'search_settings' );

function search_settings( $settings_pages ) {
	$settings_pages[] = [
        'menu_title' => __( 'Search Settings', 'search_settings' ),
        'id'         => 'search-settings',
        'position'   => 2,
        'style'      => 'no-boxes',
        'columns'    => 1,
        'icon_url'   => 'dashicons-admin-generic',
    ];

	return $settings_pages;
}

add_filter( 'rwmb_meta_boxes', 'search_settings_cta' );

function search_settings_cta( $meta_boxes ) {
    $prefix = '';

    $mb = [
        'title'          => __( 'CTA block %LANG%', 'search_settings_cta_%LANG%' ),
        'settings_pages' => ['search-settings'],
        'fields'         => [
            [
                'type' => 'heading',
                'name' => __( 'CTA block settings %LANG%', 'search_settings_heading_cta_%LANG%' ),
            ],
            [
                'name' => __( 'Title %LANG%', 'search_settings_cta_%LANG%' ),
                'id'   => $prefix . 'cta_title_%LANG%',
                'type' => 'text',
            ],
            [
                'name' => __( 'Content %LANG%', 'search_settings_cta_%LANG%' ),
                'id'   => $prefix . 'cta_content_%LANG%',
                'type' => 'textarea',
            ],
            [
                'name' => __( 'Content link url %LANG%', 'search_settings_cta_%LANG%' ),
                'id'   => $prefix . 'cta_content_link_url_%LANG%',
                'type' => 'url',
            ],
            [
                'name' => __( 'Content link text %LANG%', 'search_settings_cta_%LANG%' ),
                'id'   => $prefix . 'cta_content_link_text_%LANG%',
                'type' => 'text',
            ],
            [
                'name' => __( 'Background Image %LANG%', 'search_settings_cta_%LANG%' ),
                'id'   => $prefix . 'cta_background_image_%LANG%',
                'type' => 'single_image',
            ],
            [
                'name' => __( 'Use form shortcode %LANG%', 'search_settings_cta_%LANG%' ),
                'id'   => $prefix . 'cta_use_form_shortcode_%LANG%',
                'type' => 'checkbox',
            ],
            [
                'name' => __( 'Form shortcode %LANG%', 'search_settings_cta_%LANG%' ),
                'id'   => $prefix . 'cta_form_shortcode_%LANG%',
                'type' => 'text',
            ],
            [
                'name'    => __( 'Font size %LANG%', 'search_settings_cta_%LANG%' ),
                'id'      => $prefix . 'cta_font_size_%LANG%',
                'type'    => 'select',
                'options' => [
                    'default' => __( 'Default', 'search_settings_cta' ),
                    'large'   => __( 'Large', 'search_settings_cta' ),
                    'xlarge'  => __( 'Extra Large', 'search_settings_cta' ),
                ],
            ],
            [
                'name'    => __( 'Color variant %LANG%', 'search_settings_cta_%LANG%' ),
                'id'      => $prefix . 'cta_color_variant_%LANG%',
                'type'    => 'select',
                'options' => [
                    'dark'  => __( 'Dark', 'search_settings_cta' ),
                    'light' => __( 'Light', 'search_settings_cta' ),
                ],
            ],
        ],
    ];
    generate_meta_boxes_custom_fields_by_laguages($mb, $meta_boxes);
    return $meta_boxes;
}