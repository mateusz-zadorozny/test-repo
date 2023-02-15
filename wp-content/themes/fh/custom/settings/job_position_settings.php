<?php

$theme_dir = get_template_directory();
require_once $theme_dir . '/custom/helpers/meta_boxes.php';

add_action( 'init', 'job_position_register_post_type' );
function job_position_register_post_type() {
	$labels = [
		'name'                     => esc_html__( 'Job positions', 'job_position' ),
		'singular_name'            => esc_html__( 'Job position', 'job_position' ),
		'add_new'                  => esc_html__( 'Add New', 'job_position' ),
		'add_new_item'             => esc_html__( 'Add New Job position', 'job_position' ),
		'edit_item'                => esc_html__( 'Edit Job position', 'job_position' ),
		'new_item'                 => esc_html__( 'New Job position', 'job_position' ),
		'view_item'                => esc_html__( 'View Job position', 'job_position' ),
		'view_items'               => esc_html__( 'View Job positions', 'job_position' ),
		'search_items'             => esc_html__( 'Search Job positions', 'job_position' ),
		'not_found'                => esc_html__( 'No job positions found.', 'job_position' ),
		'not_found_in_trash'       => esc_html__( 'No job positions found in Trash.', 'job_position' ),
		'parent_item_colon'        => esc_html__( 'Parent Job position:', 'job_position' ),
		'all_items'                => esc_html__( 'All Job positions', 'job_position' ),
		'archives'                 => esc_html__( 'Job position Archives', 'job_position' ),
		'attributes'               => esc_html__( 'Job position Attributes', 'job_position' ),
		'insert_into_item'         => esc_html__( 'Insert into job position', 'job_position' ),
		'uploaded_to_this_item'    => esc_html__( 'Uploaded to this job position', 'job_position' ),
		'featured_image'           => esc_html__( 'Featured image', 'job_position' ),
		'set_featured_image'       => esc_html__( 'Set featured image', 'job_position' ),
		'remove_featured_image'    => esc_html__( 'Remove featured image', 'job_position' ),
		'use_featured_image'       => esc_html__( 'Use as featured image', 'job_position' ),
		'menu_name'                => esc_html__( 'Job positions', 'job_position' ),
		'filter_items_list'        => esc_html__( 'Filter job positions list', 'job_position' ),
		'filter_by_date'           => esc_html__( '', 'job_position' ),
		'items_list_navigation'    => esc_html__( 'Job positions list navigation', 'job_position' ),
		'items_list'               => esc_html__( 'Job positions list', 'job_position' ),
		'item_published'           => esc_html__( 'Job position published.', 'job_position' ),
		'item_published_privately' => esc_html__( 'Job position published privately.', 'job_position' ),
		'item_reverted_to_draft'   => esc_html__( 'Job position reverted to draft.', 'job_position' ),
		'item_scheduled'           => esc_html__( 'Job position scheduled.', 'job_position' ),
		'item_updated'             => esc_html__( 'Job position updated.', 'job_position' ),
		'text_domain'              => esc_html__( 'job_position', 'job_position' ),
	];
	$args = [
		'label'               => esc_html__( 'Job positions', 'job_position' ),
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
		'supports'            => ['title', 'editor', 'thumbnail', 'excerpt'],
		'taxonomies'          => [],
		'rewrite'             => [
			'with_front' => 'content-single-job-position',
		],
	];

	register_post_type( 'job-position', $args );
}

add_action( 'init', 'job_category_register_taxonomy' );
function job_category_register_taxonomy() {
	$labels = [
		'name'                       => esc_html__( 'Job categories', 'job_category' ),
		'singular_name'              => esc_html__( 'Job category', 'job_category' ),
		'menu_name'                  => esc_html__( 'Job categories', 'job_category' ),
		'search_items'               => esc_html__( 'Search Job categories', 'job_category' ),
		'popular_items'              => esc_html__( 'Popular Job categories', 'job_category' ),
		'all_items'                  => esc_html__( 'All Job categories', 'job_category' ),
		'parent_item'                => esc_html__( 'Parent Job category', 'job_category' ),
		'parent_item_colon'          => esc_html__( 'Parent Job category:', 'job_category' ),
		'edit_item'                  => esc_html__( 'Edit Job category', 'job_category' ),
		'view_item'                  => esc_html__( 'View Job category', 'job_category' ),
		'update_item'                => esc_html__( 'Update Job category', 'job_category' ),
		'add_new_item'               => esc_html__( 'Add New Job category', 'job_category' ),
		'new_item_name'              => esc_html__( 'New Job category Name', 'job_category' ),
		'separate_items_with_commas' => esc_html__( 'Separate job position categories with commas', 'job_category' ),
		'add_or_remove_items'        => esc_html__( 'Add or remove job position categories', 'job_category' ),
		'choose_from_most_used'      => esc_html__( 'Choose most used job position categories', 'job_category' ),
		'not_found'                  => esc_html__( 'No job position categories found.', 'job_category' ),
		'no_terms'                   => esc_html__( 'No job position categories', 'job_category' ),
		'filter_by_item'             => esc_html__( 'Filter by job position category', 'job_category' ),
		'items_list_navigation'      => esc_html__( 'Job categories list pagination', 'job_category' ),
		'items_list'                 => esc_html__( 'Job categories list', 'job_category' ),
		'most_used'                  => esc_html__( 'Most Used', 'job_category' ),
		'back_to_items'              => esc_html__( '&larr; Go to Job categories', 'job_category' ),
		'text_domain'                => esc_html__( 'job_category', 'job_category' ),
	];
	$args = [
		'label'              => esc_html__( 'Job categories', 'job_category' ),
		'labels'             => $labels,
		'description'        => '',
		'public'             => true,
		'publicly_queryable' => true,
		'hierarchical'       => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'show_in_rest'       => true,
		'show_tagcloud'      => true,
		'show_in_quick_edit' => true,
		'show_admin_column'  => false,
		'query_var'          => true,
		'sort'               => false,
		'meta_box_cb'        => 'post_tags_meta_box',
		'rest_base'          => '',
		'rewrite'            => [
			'with_front'   => false,
			'hierarchical' => false,
		],
	];
	register_taxonomy( 'job-category', ['job-position'], $args );
}

add_action( 'init', 'job_localization_register_taxonomy' );
function job_localization_register_taxonomy() {
	$labels = [
		'name'                       => esc_html__( 'Job localizations', 'your-textdomain' ),
		'singular_name'              => esc_html__( 'Job localization', 'your-textdomain' ),
		'menu_name'                  => esc_html__( 'Job localizations', 'your-textdomain' ),
		'search_items'               => esc_html__( 'Search Job localizations', 'your-textdomain' ),
		'popular_items'              => esc_html__( 'Popular Job localizations', 'your-textdomain' ),
		'all_items'                  => esc_html__( 'All Job localizations', 'your-textdomain' ),
		'parent_item'                => esc_html__( 'Parent Job localization', 'your-textdomain' ),
		'parent_item_colon'          => esc_html__( 'Parent Job localization:', 'your-textdomain' ),
		'edit_item'                  => esc_html__( 'Edit Job localization', 'your-textdomain' ),
		'view_item'                  => esc_html__( 'View Job localization', 'your-textdomain' ),
		'update_item'                => esc_html__( 'Update Job localization', 'your-textdomain' ),
		'add_new_item'               => esc_html__( 'Add New Job localization', 'your-textdomain' ),
		'new_item_name'              => esc_html__( 'New Job localization Name', 'your-textdomain' ),
		'separate_items_with_commas' => esc_html__( 'Separate job localizations with commas', 'your-textdomain' ),
		'add_or_remove_items'        => esc_html__( 'Add or remove job localizations', 'your-textdomain' ),
		'choose_from_most_used'      => esc_html__( 'Choose most used job localizations', 'your-textdomain' ),
		'not_found'                  => esc_html__( 'No job localizations found.', 'your-textdomain' ),
		'no_terms'                   => esc_html__( 'No job localizations', 'your-textdomain' ),
		'filter_by_item'             => esc_html__( 'Filter by job localization', 'your-textdomain' ),
		'items_list_navigation'      => esc_html__( 'Job localizations list pagination', 'your-textdomain' ),
		'items_list'                 => esc_html__( 'Job localizations list', 'your-textdomain' ),
		'most_used'                  => esc_html__( 'Most Used', 'your-textdomain' ),
		'back_to_items'              => esc_html__( '&larr; Go to Job localizations', 'your-textdomain' ),
		'text_domain'                => esc_html__( 'your-textdomain', 'your-textdomain' ),
	];
	$args = [
		'label'              => esc_html__( 'Job localizations', 'your-textdomain' ),
		'labels'             => $labels,
		'description'        => '',
		'public'             => true,
		'publicly_queryable' => true,
		'hierarchical'       => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'show_in_rest'       => true,
		'show_tagcloud'      => true,
		'show_in_quick_edit' => true,
		'show_admin_column'  => false,
		'query_var'          => true,
		'sort'               => false,
		'meta_box_cb'        => 'post_tags_meta_box',
		'rest_base'          => '',
		'rewrite'            => [
			'with_front'   => false,
			'hierarchical' => false,
		],
	];
	register_taxonomy( 'job-localization', [ 'job-position'], $args );
}

add_action( 'init', 'job_country_register_taxonomy' );
function job_country_register_taxonomy() {
	$labels = [
		'name'                       => esc_html__( 'Job countries', 'job_country' ),
		'singular_name'              => esc_html__( 'Job country', 'job_country' ),
		'menu_name'                  => esc_html__( 'Job countries', 'job_country' ),
		'search_items'               => esc_html__( 'Search Job countries', 'job_country' ),
		'popular_items'              => esc_html__( 'Popular Job countries', 'job_country' ),
		'all_items'                  => esc_html__( 'All Job countries', 'job_country' ),
		'parent_item'                => esc_html__( 'Parent Job country', 'job_country' ),
		'parent_item_colon'          => esc_html__( 'Parent Job country:', 'job_country' ),
		'edit_item'                  => esc_html__( 'Edit Job country', 'job_country' ),
		'view_item'                  => esc_html__( 'View Job country', 'job_country' ),
		'update_item'                => esc_html__( 'Update Job country', 'job_country' ),
		'add_new_item'               => esc_html__( 'Add New Job country', 'job_country' ),
		'new_item_name'              => esc_html__( 'New Job country Name', 'job_country' ),
		'separate_items_with_commas' => esc_html__( 'Separate job countries with commas', 'job_country' ),
		'add_or_remove_items'        => esc_html__( 'Add or remove job countries', 'job_country' ),
		'choose_from_most_used'      => esc_html__( 'Choose most used job countries', 'job_country' ),
		'not_found'                  => esc_html__( 'No job countries found.', 'job_country' ),
		'no_terms'                   => esc_html__( 'No job countries', 'job_country' ),
		'filter_by_item'             => esc_html__( 'Filter by job country', 'job_country' ),
		'items_list_navigation'      => esc_html__( 'Job countries list pagination', 'job_country' ),
		'items_list'                 => esc_html__( 'Job countries list', 'job_country' ),
		'most_used'                  => esc_html__( 'Most Used', 'job_country' ),
		'back_to_items'              => esc_html__( '&larr; Go to Job countries', 'job_country' ),
		'text_domain'                => esc_html__( 'job_country', 'job_country' ),
	];
	$args = [
		'label'              => esc_html__( 'Job countries', 'job_country' ),
		'labels'             => $labels,
		'description'        => '',
		'public'             => true,
		'publicly_queryable' => true,
		'hierarchical'       => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'show_in_rest'       => true,
		'show_tagcloud'      => true,
		'show_in_quick_edit' => true,
		'show_admin_column'  => false,
		'query_var'          => true,
		'sort'               => false,
		'meta_box_cb'        => 'post_tags_meta_box',
		'rest_base'          => '',
		'rewrite'            => [
			'with_front'   => false,
			'hierarchical' => false,
		],
	];
	register_taxonomy( 'job-country', ['job-position'], $args );
}

add_action( 'init', 'job_type_register_taxonomy' );
function job_type_register_taxonomy() {
	$labels = [
		'name'                       => esc_html__( 'Job types', 'job_type' ),
		'singular_name'              => esc_html__( 'Job type', 'job_type' ),
		'menu_name'                  => esc_html__( 'Job types', 'job_type' ),
		'search_items'               => esc_html__( 'Search Job types', 'job_type' ),
		'popular_items'              => esc_html__( 'Popular Job types', 'job_type' ),
		'all_items'                  => esc_html__( 'All Job types', 'job_type' ),
		'parent_item'                => esc_html__( 'Parent Job type', 'job_type' ),
		'parent_item_colon'          => esc_html__( 'Parent Job type:', 'job_type' ),
		'edit_item'                  => esc_html__( 'Edit Job type', 'job_type' ),
		'view_item'                  => esc_html__( 'View Job type', 'job_type' ),
		'update_item'                => esc_html__( 'Update Job type', 'job_type' ),
		'add_new_item'               => esc_html__( 'Add New Job type', 'job_type' ),
		'new_item_name'              => esc_html__( 'New Job type Name', 'job_type' ),
		'separate_items_with_commas' => esc_html__( 'Separate job types with commas', 'job_type' ),
		'add_or_remove_items'        => esc_html__( 'Add or remove job types', 'job_type' ),
		'choose_from_most_used'      => esc_html__( 'Choose most used job types', 'job_type' ),
		'not_found'                  => esc_html__( 'No job types found.', 'job_type' ),
		'no_terms'                   => esc_html__( 'No job types', 'job_type' ),
		'filter_by_item'             => esc_html__( 'Filter by job type', 'job_type' ),
		'items_list_navigation'      => esc_html__( 'Job types list pagination', 'job_type' ),
		'items_list'                 => esc_html__( 'Job types list', 'job_type' ),
		'most_used'                  => esc_html__( 'Most Used', 'job_type' ),
		'back_to_items'              => esc_html__( '&larr; Go to Job types', 'job_type' ),
		'text_domain'                => esc_html__( 'job_type', 'job_type' ),
	];
	$args = [
		'label'              => esc_html__( 'Job types', 'job_type' ),
		'labels'             => $labels,
		'description'        => '',
		'public'             => true,
		'publicly_queryable' => true,
		'hierarchical'       => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'show_in_rest'       => true,
		'show_tagcloud'      => true,
		'show_in_quick_edit' => true,
		'show_admin_column'  => false,
		'query_var'          => true,
		'sort'               => false,
		'meta_box_cb'        => 'post_tags_meta_box',
		'rest_base'          => '',
		'rewrite'            => [
			'with_front'   => false,
			'hierarchical' => false,
		],
	];
	register_taxonomy( 'job-type', ['job-position'], $args );
}

add_filter( 'rwmb_meta_boxes', 'job_position_settings' );

function job_position_settings( $meta_boxes ) {
    $prefix = '';

    $meta_boxes[] = [
        'title'      => __( 'Job position settings', 'job-position-settings' ),
        'post_types' => ['job-position'],
        'fields'     => [
            [
                'name' => __( 'Pay scale amount', 'job-position-settings' ),
                'id'   => $prefix . 'pay_scale_amount',
                'type' => 'text',
            ],
            [
                'name' => __( 'Pay scale info', 'job-position-settings' ),
                'id'   => $prefix . 'pay_scale_info',
                'type' => 'text',
            ],
            [
                'name' => __( 'Job description', 'job-position-settings' ),
                'id'   => $prefix . 'job_description',
                'type' => 'wysiwyg',
            ],
            [
                'name' => __( 'Form title', 'job-position-settings' ),
                'id'   => $prefix . 'form_title',
                'type' => 'textarea',
            ],
            [
                'name' => __( 'Form short code', 'job-position-settings' ),
                'id'   => $prefix . 'form_short_code',
                'type' => 'text',
            ],
        ],
    ];

    return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'job_benefits' );

function job_benefits( $meta_boxes ) {
    $prefix = 'job_benefits_';

    $meta_boxes[] = [
        'title'      => __( 'Job benefits', 'job-benefits' ),
        'post_types' => ['job-position'],
        'fields'     => [
            [
                'name'    => __( 'Title', 'job-benefits' ),
                'id'      => $prefix . 'title',
                'type'    => 'text',
                'columns' => 3,
            ],
            [
                'name'    => __( 'Group', 'job-benefits' ),
                'id'      => $prefix . 'group_1',
                'type'    => 'group',
                'columns' => 3,
                'fields'  => [
                    [
                        'name' => __( 'Icon', 'job-benefits' ),
                        'id'   => $prefix . 'icon_1',
                        'type' => 'single_image',
                    ],
                    [
                        'name' => __( 'title', 'job-benefits' ),
                        'id'   => $prefix . 'title_1',
                        'type' => 'textarea',
                    ],
                    [
                        'name' => __( 'Content', 'job-benefits' ),
                        'id'   => $prefix . 'content_1',
                        'type' => 'wysiwyg',
                    ],
                ],
            ],
            [
                'name'    => __( 'Group ', 'job-benefits' ),
                'id'      => $prefix . 'group_2',
                'type'    => 'group',
                'columns' => 3,
                'fields'  => [
                    [
                        'name' => __( 'Icon', 'job-benefits' ),
                        'id'   => $prefix . 'icon_2',
                        'type' => 'single_image',
                    ],
                    [
                        'name' => __( 'title', 'job-benefits' ),
                        'id'   => $prefix . 'title_2',
                        'type' => 'textarea',
                    ],
                    [
                        'name' => __( 'Content', 'job-benefits' ),
                        'id'   => $prefix . 'content_2',
                        'type' => 'wysiwyg',
                    ],
                ],
            ],
            [
                'name'    => __( 'Group  ', 'job-benefits' ),
                'id'      => $prefix . 'group_3',
                'type'    => 'group',
                'columns' => 3,
                'fields'  => [
                    [
                        'name' => __( 'Icon', 'job-benefits' ),
                        'id'   => $prefix . 'icon_3',
                        'type' => 'single_image',
                    ],
                    [
                        'name' => __( 'title', 'job-benefits' ),
                        'id'   => $prefix . 'title_3',
                        'type' => 'textarea',
                    ],
                    [
                        'name' => __( 'Content', 'job-benefits' ),
                        'id'   => $prefix . 'content_3',
                        'type' => 'wysiwyg',
                    ],
                ],
            ],
        ],
    ];

    return $meta_boxes;
}


add_filter( 'mb_settings_pages', 'career_settings' );

function career_settings( $settings_pages ) {
	$settings_pages[] = [
        'menu_title' => __( 'Career Settings', 'career_settings' ),
        'id'         => 'career-settings',
        'position'   => 1,
        'style'      => 'no-boxes',
        'columns'    => 1,
        'icon_url'   => 'dashicons-admin-generic',
    ];

	return $settings_pages;
}

add_filter( 'rwmb_meta_boxes', 'career_options' );

function career_options( $meta_boxes ) {
    $prefix = '';

    $mb = [
        'title'          => __( 'Options %LANG%', 'career-options-%LANG%' ),
        'settings_pages' => ['career-settings'],
        'fields'         => [
            [
                'name'      => __( 'Career page %LANG%', 'career-options-%LANG%' ),
                'id'        => $prefix . 'career_page_%LANG%',
                'type'      => 'post',
                'post_type' => ['page'],
            ],
        ],
    ];

    generate_meta_boxes_custom_fields_by_laguages($mb, $meta_boxes);
    return $meta_boxes;
}

function prepareJobTaxonomiesToShow($id)
{
    $terms = wp_get_post_terms($id, ['job-category', 'job-localization', 'job-type', 'job-country']);
    $categories = []; 
    $localizations = []; 
    $types = []; 
    $countries = []; 
    
    foreach ($terms as $term) {
        switch ($term->taxonomy ) {
            case 'job-category': 
                $categories[] = $term->name;
                break;
            case 'job-localization': 
                $localizations[] = $term->name;
                break;
            case 'job-type': 
                $types[] = $term->name;
                break;
            case 'job-country': 
                $countries[] = $term->name;
                break;
            default:
                break;
        }
    }
    
    return [
            $localizations,
            $types,
            $countries,
            $categories
        ];
    
}