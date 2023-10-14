<?php
/**
 * Plugin Name: Sean Michael - API Block Challenge
 * Plugin URI: https://awesomemotive.com/developer-applicant-challenge/
 * Description: Awesome Motive code challenge. This plugin creates a block that displays data from an API endpoint.
 * Version: 1.0.0
 * Author: Sean Michael P.
 * Text Domain: sm-api-block
 *
 * @package WordPress
 */

// Load config file.
require_once plugin_dir_path( __FILE__ ) . '/config.php';

/**
 * Initialize the plugin.
 *
 * @since 1.0.0
 *
 * @return void
 */
function sm_api_block_run() {

	// Load core class.
	require_once SM_API_BLOCK_PATH_INCLUDES . 'class-sm-api-block-core.php';

	// Initialize the core class.
	$sm_api_block_core = new Sm_Api_Block_Core(
		SM_API_BLOCK_PLUGIN_NAME,
		SM_API_BLOCK_SLUG,
		SM_API_BLOCK_VERSION
	);

	// Run the core class.
	$sm_api_block_core->init();
}
add_action( 'plugins_loaded', 'sm_api_block_run' );

/**
 * Deactivation hook.
 *
 * @since 1.0.0
 *
 * @return void
 */
function sm_api_block_deactivation() {

	// Get the transient name.
	$transient_name = apply_filters(
		SM_API_BLOCK_FILTER_ROUTE_TABLE_TRANSIENT_NAME,
		SM_API_BLOCK_TRANSIENT_ROUTE_TABLE_NAME
	);

	// Clear transient.
	delete_transient( $transient_name );
}
register_deactivation_hook( __FILE__, 'sm_api_block_deactivation' );
