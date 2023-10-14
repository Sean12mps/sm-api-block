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
	public $slug;

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
	 * @param string $slug  Plugin text domain.
	 * @param string $version      Plugin version.
	 *
	 * @return void
	 */
	public function __construct( $name, $slug, $version ) {

		// Set plugin info.
		$this->name    = $name;
		$this->slug    = $slug;
		$this->version = $version;
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

		// Load admin hooks.
		if ( is_admin() ) {
			$this->load_hooks_admin();
		}
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

		// Gutenberg.
		require_once SM_API_BLOCK_PATH_INCLUDES . 'class-sm-api-block-gutenberg.php';

		// Admin.
		if ( is_admin() ) {
			require_once SM_API_BLOCK_PATH_INCLUDES . 'class-sm-api-block-admin.php';
		}

		// CLI.
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			require_once SM_API_BLOCK_PATH_INCLUDES . 'class-sm-api-block-cli.php';
		}
	}

	/**
	 * Admin hooks.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function load_hooks_admin() {

		// Initialize the admin class.
		$handler_admin = new Sm_Api_Block_Admin(
			$this->name,
			$this->slug,
			$this->version
		);

		// Register scripts.
		add_action( 'admin_enqueue_scripts', array( $handler_admin, 'register_admin_scripts' ) );

		// Enenqueue scripts.
		add_action( 'admin_enqueue_scripts', array( $handler_admin, 'enqueue_admin_scripts' ) );

		// Register admin menu.
		add_action( 'admin_menu', array( $handler_admin, 'register_admin_menu' ) );

		// Register admin header.
		add_action( 'in_admin_header', array( $handler_admin, 'display_admin_header' ) );

		// Setting form response.
		add_action( 'admin_post_' . SM_API_BLOCK_SETTING_ACTION_NAME, array( $handler_admin, 'handle_admin_setting_form_submission' ) );
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
			$this->slug,
			$this->version
		);

		// Initialize the Gutenberg class.
		$handler_gutenberg = new Sm_Api_Block_Gutenberg(
			$this->name,
			$this->slug,
			$this->version
		);

		// Hook into WP routes.
		add_action( 'rest_api_init', array( $handler_endpoint, 'register_routes' ) );

		// Register block.
		add_action( 'init', array( $handler_gutenberg, 'register_blocks' ) );

		// Register CLI.
		add_action( 'cli_init', array( $this, 'register_cli' ) );
	}

	/**
	 * Register plugin CLI.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_cli() {

		// Check if WP CLI is available.
		if ( ! class_exists( 'WP_CLI' ) ) {
			return;
		}

		// Command name.
		$command_name = apply_filters(
			SM_API_BLOCK_FILTER_CLI_COMMAND_NAME,
			SM_API_BLOCK_CLI_COMMAND_NAME
		);

		WP_CLI::add_command( $command_name, 'Sm_Api_Block_Cli' );
	}
}
