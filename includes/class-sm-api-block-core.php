<?php
/**
 * Core plugin class.
 *
 * @package WordPress
 */

/**
 * Manage the plugin functionality.
 *
 * @since 1.0.0
 */
class Sm_Api_Block_Core {

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
	 * Initialize the plugin.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function init() {

		// Load dependencies.
		$this->load_dependencies();

		// Load public hooks.
		$this->load_hooks_public();
	}

	/**
	 * Load dependencies.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function load_dependencies() {

		// Endpoint handler class.
		require_once SM_API_BLOCK_PATH_INCLUDES . 'class-sm-api-block-endpoint.php';

		// Models.
		require_once SM_API_BLOCK_PATH_MODELS . 'class-sm-api-block-model-endpoint.php';

		// Endpoints.
		require_once SM_API_BLOCK_PATH_ENDPOINTS . 'class-sm-api-block-endpoint-table.php';

		// Request.
		require_once SM_API_BLOCK_PATH_INCLUDES . 'class-sm-api-block-request.php';
	}

	/**
	 * Public hooks.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function load_hooks_public() {

		// Initialize the endpoint class.
		$handler_endpoint = new Sm_Api_Block_Endpoint(
			$this->name,
			$this->text_domain,
			$this->version
		);

		// Hook into WP routes.
		add_action( 'rest_api_init', array( $handler_endpoint, 'register_routes' ) );
	}
}
