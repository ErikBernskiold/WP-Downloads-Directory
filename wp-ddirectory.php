<?php
/**
 * Plugin Name: WP Downloads Directory
 * Plugin URI: https://github.com/ErikBernskiold/WP-Downloads-Directory
 * Author: XLD Studios
 * Author URI: http://www.xldstudios.com/
 * Description: A simple downloads directory.
 * Version: 1.0
 * Requires at least: 3.5
 * Tested up to: 3.5.2
 * License: GPL2
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) )
	exit;

/**
 * Ilmenite Job Board Class
 */
class WP_Downloads_Directory {

	/**
	 * Constructor
	 */
	public function __construct() {

		// Define some constants
		define( 'WP_DDIR_VERSION', '1.0' );
		define( 'WP_DDIR_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
		define( 'WP_DDIR_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );

		// Include classes and functions
		include( 'inc/class-wp-ddirectory-post-types.php' );
		include( 'inc/class-wp-ddirectory-shortcodes.php' );

		// Initialize classes...
		$this->post_types = new WP_Downloads_Directory_Post_Types();

		// Add the textdomain and support translation
		add_action( 'plugins_loaded', array( $this, 'add_textdomain' ) );

		// Add Stylesheets
		add_action( 'wp_enqueue_scripts', array( $this, 'stylesheets' ) );

		// Add plugin updater
		add_action( 'init', array( $this, 'plugin_update' ) );
	}

	/**
	 * Add textdomain for plugin
	 */
	public function add_textdomain() {
		load_plugin_textdomain( 'wpddirectory', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Auto Update Support
	 *
	 * Adds support for auto-updating from GitHub repository.
	 */
	public function plugin_update() {

		// Include updater class
		include( 'inc/class-github-updater.php' );

		// If this hasn't already been called.
		if ( ! defined( 'WP_GITHUB_FORCE_UPDATE' ) )
			define( 'WP_GITHUB_FORCE_UPDATE', true );

		if ( is_admin() ) { // note the use of is_admin() to double check that this is happening in the admin

			$config = array(
				'slug'               => plugin_basename( __FILE__ ),
				'proper_folder_name' => 'wp-downloads-directory',
				'api_url'            => 'https://api.github.com/repos/ErikBernskiold/WP-Downloads-Directory',
				'raw_url'            => 'https://raw.github.com/ErikBernskiold/WP-Downloads-Directory/master',
				'github_url'         => 'https://github.com/ErikBernskiold/WP-Downloads-Directory',
				'zip_url'            => 'https://github.com/ErikBernskiold/WP-Downloads-Directory/archive/master.zip',
				'sslverify'          => true,
				'requires'           => '3.5',
				'tested'             => '3.5.2',
				'readme'             => 'README.md',
			);

			new WP_GitHub_Updater( $config );

		}

	}

	/**
	 * Load Styles
	 */
	public function stylesheets() {

		wp_register_style( 'downloads-directory', WP_DDIR_PLUGIN_URL . '/assets/css/downloads-directory.css', false, WP_DDIR_VERSION, 'all' );

		wp_enqueue_style( 'downloads-directory' );

	}


}

// Initialize everything
$GLOBALS['wp_downloads_directory'] = new WP_Downloads_Directory();