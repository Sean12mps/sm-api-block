<?php
/**
 * Admin manager class.
 *
 * @package WordPress
 */

/**
 * Manage the admin functionality.
 *
 * @since 1.0.0
 */
class Sm_Api_Block_Admin {

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
	 * Admin styles.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $admin_styles;

	/**
	 * Admin scripts.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $admin_scripts;

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

		// Class info.
		$this->admin_styles  = wp_sprintf( '%s-admin-styles', $this->slug );
		$this->admin_scripts = wp_sprintf( '%s-admin-scripts', $this->slug );
	}

	/**
	 * Check if current page is plugin admin page.
	 *
	 * @since 1.0.0
	 *
	 * @return bool
	 */
	public function is_plugin_admin_page() {

		// Get current screen.
		$current_screen = get_current_screen();

		// Check if current screen is admin page.
		return ( 'toplevel_page_' . $this->slug === $current_screen->id );
	}

	/**
	 * Register admin scripts.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_admin_scripts() {

		// Register admin styles.
		wp_register_style(
			$this->admin_styles,
			SM_API_BLOCK_PATH_ASSETS . 'css/admin.css',
			array(),
			$this->version,
			'all'
		);

		// Register admin scripts.
		wp_register_script(
			$this->admin_scripts,
			SM_API_BLOCK_PATH_ASSETS . 'js/admin.js',
			array( 'jquery' ),
			$this->version,
			true
		);
	}

	/**
	 * Enqueue admin scripts.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function enqueue_admin_scripts() {

		// Get current screen.
		$current_screen = get_current_screen();

		// Check if current screen is admin page.
		if ( $this->is_plugin_admin_page() ) {

			// Enqueue admin styles.
			wp_enqueue_style( $this->admin_styles );

			// Enqueue admin scripts.
			wp_enqueue_script( $this->admin_scripts );
		}
	}

	/**
	 * Register admin menu.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function register_admin_menu() {

		// Add menu page.
		add_menu_page(
			__( 'Sean API Block', 'sm-api-block' ),
			__( 'API Block Options', 'sm-api-block' ),
			'edit_posts',
			$this->slug,
			array( $this, 'render_admin_page' ),
			'dashicons-admin-generic'
		);
	}

	/**
	 * Display admin header
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function display_admin_header() {

		// Check if current screen is admin page.
		if ( $this->is_plugin_admin_page() ) {

			// Require admin header template.
			require_once SM_API_BLOCK_PATH_INCLUDES . '/admin/header.php';
		}
	}

	/**
	 * Render admin page.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function render_admin_page() {

		// Require admin page template.
		require_once SM_API_BLOCK_PATH_INCLUDES . '/admin/page.php';
	}

	/**
	 * Handle admin settings.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function handle_admin_setting_form_submission() {

		// Check if nonce is valid.
		check_admin_referer( SM_API_BLOCK_SETTING_ACTION_NAME, SM_API_BLOCK_SETTING_NONCE_NAME );

		// Check if user has permissions.
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html( SM_API_BLOCK_NOTICE_ERROR_NOT_SUFFICIENT_PERMISSIONS ) );
		}

		// Get referer URL.
		$referer_url = wp_get_referer();

		// Get request button.
		$request_button = isset( $_POST['submit'] ) ? sanitize_text_field( wp_unslash( $_POST['submit'] ) ) : '';

		// Notice message.
		$notice_code = '';

		// Switch request button.
		switch ( $request_button ) {
			case 'clear-cache':
				// Clear transient.
				$transient_deleted = delete_transient( SM_API_BLOCK_TRANSIENT_ROUTE_TABLE_NAME );
				// Set notice message.
				$notice_code = $transient_deleted ? 'clear-cache-success' : 'clear-cache-failed';
				break;
		}

		// Add query args.
		$referer_url = add_query_arg(
			array(
				'notice' => $notice_code,
			),
			$referer_url
		);

		// Redirect to previous page.
		wp_safe_redirect( $referer_url );
		exit;
	}
}
