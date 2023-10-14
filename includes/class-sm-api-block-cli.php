<?php
/**
 * Plugin CLI.
 *
 * @package WordPress
 */

/**
 * Add CLI functionality.
 *
 * @since 1.0.0
 */
class Sm_Api_Block_Cli {

	/**
	 * Clear transient.
	 *
	 * ## EXAMPLES
	 *
	 *    wp sm-api-block clear-transient
	 *
	 * @when after_wp_load
	 *
	 * @since 1.0.0
	 */
	function clear_transient() {

		// Get transient name.
		$transient_name = apply_filters(
			SM_API_BLOCK_FILTER_ROUTE_TABLE_TRANSIENT_NAME,
			SM_API_BLOCK_TRANSIENT_ROUTE_TABLE_NAME
		);

		// Delete transient.
		delete_transient( $transient_name );

		// Success message.
		WP_CLI::success( __( 'Transient cleared.', 'sm-api-block' ) );
	}
}
