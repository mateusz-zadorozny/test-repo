<?php


add_action( 'init', 'partner_register_post_type' );

function partner_register_post_type() {
	$labels = [
		'name'                     => esc_html__( 'Partners', 'partner' ),
		'singular_name'            => esc_html__( 'Partner', 'partner' ),
		'add_new'                  => esc_html__( 'Add New', 'partner' ),
		'add_new_item'             => esc_html__( 'Add New Partner', 'partner' ),
		'edit_item'                => esc_html__( 'Edit Partner', 'partner' ),
		'new_item'                 => esc_html__( 'New Partner', 'partner' ),
		'view_item'                => esc_html__( 'View Partner', 'partner' ),
		'view_items'               => esc_html__( 'View Partners', 'partner' ),
		'search_items'             => esc_html__( 'Search Partners', 'partner' ),
		'not_found'                => esc_html__( 'No partners found.', 'partner' ),
		'not_found_in_trash'       => esc_html__( 'No partners found in Trash.', 'partner' ),
		'parent_item_colon'        => esc_html__( 'Parent Partner:', 'partner' ),
		'all_items'                => esc_html__( 'All Partners', 'partner' ),
		'archives'                 => esc_html__( 'Partner Archives', 'partner' ),
		'attributes'               => esc_html__( 'Partner Attributes', 'partner' ),
		'insert_into_item'         => esc_html__( 'Insert into partner', 'partner' ),
		'uploaded_to_this_item'    => esc_html__( 'Uploaded to this partner', 'partner' ),
		'featured_image'           => esc_html__( 'Featured image', 'partner' ),
		'set_featured_image'       => esc_html__( 'Set featured image', 'partner' ),
		'remove_featured_image'    => esc_html__( 'Remove featured image', 'partner' ),
		'use_featured_image'       => esc_html__( 'Use as featured image', 'partner' ),
		'menu_name'                => esc_html__( 'Partners', 'partner' ),
		'filter_items_list'        => esc_html__( 'Filter partners list', 'partner' ),
		'filter_by_date'           => esc_html__( '', 'partner' ),
		'items_list_navigation'    => esc_html__( 'Partners list navigation', 'partner' ),
		'items_list'               => esc_html__( 'Partners list', 'partner' ),
		'item_published'           => esc_html__( 'Partner published.', 'partner' ),
		'item_published_privately' => esc_html__( 'Partner published privately.', 'partner' ),
		'item_reverted_to_draft'   => esc_html__( 'Partner reverted to draft.', 'partner' ),
		'item_scheduled'           => esc_html__( 'Partner scheduled.', 'partner' ),
		'item_updated'             => esc_html__( 'Partner updated.', 'partner' ),
		'text_domain'              => esc_html__( 'partner', 'partner' ),
	];
	$args = [
		'label'               => esc_html__( 'Partners', 'partner' ),
		'labels'              => $labels,
		'description'         => '',
		'public'              => true,
		'hierarchical'        => false,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'show_ui'             => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'show_in_rest'        => true,
		'query_var'           => true,
		'can_export'          => true,
		'delete_with_user'    => true,
		'has_archive'         => false,
		'rest_base'           => '',
		'show_in_menu'        => true,
		'menu_position'       => '',
		'menu_icon'           => 'dashicons-admin-generic',
		'capability_type'     => 'post',
		'supports'            => ['title', 'thumbnail', 'excerpt'],
		'taxonomies'          => [],
		'rewrite'             => [
			'with_front' => true,
		],
	];

	register_post_type( 'partner', $args );
}

add_filter( 'rwmb_meta_boxes', 'partner_data' );

function partner_data( $meta_boxes ) {
    $prefix = '';

    $meta_boxes[] = [
        'title'      => __( 'Partner data', 'partner-data' ),
        'id'         => 'partner-data',
        'post_types' => ['partner'],
        'fields'     => [
            [
                'name' => __( 'Logo', 'partner-data' ),
                'id'   => $prefix . 'logo',
                'type' => 'single_image',
            ],
            [
                'name' => __( 'Url', 'partner-data' ),
                'id'   => $prefix . 'url',
                'type' => 'url',
            ],
            [
                'name' => __( 'Description', 'partner-data' ),
                'id'   => $prefix . 'description',
                'type' => 'textarea',
            ],
        ],
    ];

    return $meta_boxes;
}
