<?php
/**
 * Post Types Class
 *
 * Sets up custom post types and taxonomies to match.
 */

/**
 * WP_Downloads_Directory_Post_Types class
 */
class WP_Downloads_Directory_Post_Types {

	/**
	 * Constructor
	 */
	public function __construct() {

		// Load the post type
		add_action( 'init', array( $this, 'register_post_type' ) );

		// Load Taxonomies
		add_action( 'init', array( $this, 'register_taxonomies' ) );

	}

	/**
	 * Registers the post type
	 */
	public function register_post_type() {

		// If the post type already exists, quit.
		if( post_type_exists( 'wpddir_downloads' ) )
			return;

		/**
		 * Downloads Post Type
		 */

		// Label Defaults
		$plural_label = __( 'Downloads', 'wpddirectory' );
		$singular_label = __( 'Download', 'wpddirectory' );

		// Register the post type
		register_post_type( 'wpddir_downloads', array(
			'labels' 				=> array(
				'name'               => $plural_label,
				'singular_name'      => $singular_label,
				'menu_name'          => $plural_label,
				'all_items'          => sprintf( __('All %s', 'wpddirectory'), $plural_label ),
				'add_new'            => __( 'Add New', 'wpddirectory' ),
				'add_new_item'       => sprintf( __('Add New %s', 'wpddirectory'), $singular_label ),
				'edit'               => __( 'Edit', 'wpddirectory' ),
				'edit_item'          => sprintf( __('Edit %s', 'wpddirectory'), $singular_label ),
				'new_item'           => sprintf( __('New %s', 'wpddirectory'), $singular_label ),
				'view'               => sprintf( __('View %s', 'wpddirectory'), $singular_label ),
				'view_item'          => sprintf( __('View %s', 'wpddirectory'), $singular_label ),
				'search_items'       => sprintf( __('Search %s', 'wpddirectory'), $plural_label ),
				'not_found'          => sprintf( __('No %s found', 'wpddirectory'), $plural_label ),
				'not_found_in_trash' => sprintf( __('No %s found in trash', 'wpddirectory'), $plural_label ),
				'parent'             => sprintf( __('Parent %s', 'wpddirectory'), $singular_label ),
			),
			'description'         => __( 'Create and manage downloads.', 'wpddirectory' ),
			'public'              => true,
			'show_ui'             => true,
			'menu_icon'				 => WP_DDIR_PLUGIN_URL . '/assets/images/post-type-icon.png',
			'capability_type'     => 'post',
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'hierarchical'        => false,
			'rewrite'             => array(
				'slug'       => _x( 'downloads', 'post type single slug', 'wpddirectory' ),
				'with_front' => false,
				'feeds'      => true,
				'pages'      => false,
			),
			'query_var'           => true,
			'supports'            => array(
				'title',
				'editor',
				'custom-fields',
				'thumbnail',
			),
//			'has_archive'         => _x( 'downloads', 'post type archive slug', 'wpddirectory' ),
			'has_archive'			 => false,
			'show_in_nav_menus'   => false,
		));

	}

	/**
	 * Register Taxonomies
	 */
	public function register_taxonomies() {

		/**
		 * Taxonomy: Job Type
		 */
		$job_type_singular = __( 'Download Category', 'wpddirectory' );
		$job_type_plural = __( 'Download Category', 'wpddirectory' );

		register_taxonomy( 'wpddir_category', 'wpddir_downloads' , array(
			'labels'            => array(
				'name'          => $job_type_plural,
				'singular_name' => $job_type_singular,
				'menu_name'     => $job_type_plural,
				'all_items'     => sprintf( __( 'All %s', 'wpddirectory' ), $job_type_plural ),
				'edit_item'     => sprintf( __( 'Edit %s', 'wpddirectory' ), $job_type_singular ),
				'view_item'     => sprintf( __( 'View %s', 'wpddirectory' ), $job_type_singular ),
				'update_item'   => sprintf( __( 'Update %s', 'wpddirectory' ), $job_type_singular ),
				'add_new_item'  => sprintf( __( 'Add New %s', 'wpddirectory' ), $job_type_singular ),
				'new_item_name' => sprintf( __( 'New %s Name', 'wpddirectory' ), $job_type_singular ),
				'parent_item'   => sprintf( __( 'Parent %s', 'wpddirectory' ), $job_type_singular ),
				'search_items'  => sprintf( __( 'Search %s', 'wpddirectory' ), $job_type_plural ),
				'popular_items' => sprintf( __( 'Popular %s', 'wpddirectory' ), $job_type_plural ),
			),
			'public'            => true,
			'show_ui'           => true,
			'show_tagcloud'     => false,
			'show_admin_column' => true,
			'hierarchical'      => true,
			'rewrite'           => false,
		));

	}

}