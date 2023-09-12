<?php
/**
 * Table endpoint handler class.
 *
 * @package WordPress
 */

/**
 * Handle the table endpoint.
 *
 * @since 1.0.0
 */
class Sm_Api_Block_Endpoint_Table extends Sm_Api_Block_Model_Endpoint {

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
	 * Register the endpoint.
	 *
	 * Add available endpoint at default:
	 * SITE_URL/wp-json/sm-api-block/v1/table
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_routes() {

		// Get the route namespace.
		$route_namespace = apply_filters( SM_API_BLOCK_FILTER_ROUTE_TABLE_NAMESPACE, $this->text_domain );

		// Get the route version.
		$route_version = apply_filters( SM_API_BLOCK_FILTER_ROUTE_TABLE_VERSION, 'v1' );

		// Get the route path.
		$route_path = apply_filters( SM_API_BLOCK_FILTER_ROUTE_TABLE_PATH, '/table' );

		// Register the route.
		register_rest_route(
			"{$route_namespace}/{$route_version}",
			$route_path,
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'callback' ),
				'permission_callback' => function () {

					// Public endpoint.
					return true;
				},
			)
		);
	}

	/**
	 * Callback.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function callback() {

		// Set the response status.
		$this->set_response_status( 200 );

		// Get the table data.
		$table_data = $this->set_response_body(
			array(
				'hello' => 'worlds',
			)
		);

		// Return the table data.
		return $this->respond();
	}
}
