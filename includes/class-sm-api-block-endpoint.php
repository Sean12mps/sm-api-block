<?php
/**
 * Endpoint handler class.
 *
 * @package WordPress
 */

/**
 * Handle the plugin rest.
 *
 * @since 1.0.0
 */
class Sm_Api_Block_Endpoint {

	/**
	 * Plugin name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $name;

	/**
	 * Plugin text domain.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $text_domain;

	/**
	 * Plugin version.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $version;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param string $name         Plugin name.
	 * @param string $text_domain  Plugin text domain.
	 * @param string $version      Plugin version.
	 *
	 * @return void
	 */
	public function __construct( $name, $text_domain, $version ) {

		// Set plugin info.
		$this->name        = $name;
		$this->text_domain = $text_domain;
		$this->version     = $version;
	}

	/**
	 * Register the routes.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_routes() {

		// Register the table route.
		$this->register_route_table();
	}

	/**
	 * Register table route.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_route_table() {

		// Load the table endpoint class.
		$route_table = new Sm_Api_Block_Endpoint_Table(
			$this->name,
			$this->text_domain,
			$this->version
		);

		// Register the route.
		$route_table->register_routes();
	}
}
