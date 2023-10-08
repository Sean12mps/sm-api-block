<?php
/**
 * Custom Gutenberg hooks.
 *
 * @package WordPress
 */

/**
 * Manage the custom Gutenberg functionality.
 *
 * @since 1.0.0
 */
class Sm_Api_Block_Gutenberg {

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
	 * Support for blocks.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	public $block_supports;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param string $name     Plugin name.
	 * @param string $slug     Plugin text domain.
	 * @param string $version  Plugin version.
	 *
	 * @return void
	 */
	public function __construct( $name, $slug, $version ) {

		// Set plugin info.
		$this->name    = $name;
		$this->slug    = $slug;
		$this->version = $version;

		// Set block supports.
		$this->block_supports = array(
			'sm-api-block/sm-api-block' => 'block_support_sm_api_block',
		);
	}

	/**
	 * Add support for specific block.
	 *
	 * @since 1.0.0
	 *
	 * @param string $block  Block name.
	 *
	 * @return void
	 */
	public function maybe_add_block_support( $block ) {

		// Get block metadata.
		$metadata_file = ( ! str_ends_with( $block, 'block.json' ) ) ?
			trailingslashit( $block ) . 'block.json' :
			$block;

		// Get block metadata.
		if ( file_exists( $metadata_file ) ) {

			// Get metadata.
			$metadata = wp_json_file_decode( $metadata_file, array( 'associative' => true ) );

			// Get block name.
			$block_name = $metadata['name'];

			// Check if block supports is set.
			if (
				isset( $this->block_supports[ $block_name ] )
				&&
				is_callable( array( $this, $this->block_supports[ $block_name ] ) )
			) {

				// Call support function.
				$this->{$this->block_supports[ $block_name ]}( $metadata );
			}
		}
	}

	/**
	 * Support for sm-api-block/sm-api-block.
	 *
	 * @since 1.0.0
	 *
	 * @param array $metadata Block metadata.
	 *
	 * @return void
	 */
	public function block_support_sm_api_block( $metadata ) {

		// Get the route URL.
		$route_namespace = apply_filters( SM_API_BLOCK_FILTER_ROUTE_TABLE_NAMESPACE, $this->slug );
		$route_version   = apply_filters( SM_API_BLOCK_FILTER_ROUTE_TABLE_VERSION, 'v1' );
		$route_path      = apply_filters( SM_API_BLOCK_FILTER_ROUTE_TABLE_PATH, '/table' );

		// Get metada attributes parentclass default.
		$parent_class = $metadata['attributes']['parentClass']['default'];

		// Localized var.
		$sm_api_block_vars = array(
			'endpointURL' => $route_namespace . '/' . $route_version . $route_path,
			'parentClass' => $parent_class,
		);

		// Localize script in editorScript.
		wp_localize_script(
			'sm-api-block-sm-api-block-editor-script',
			'smApiBlock',
			$sm_api_block_vars
		);

		// Localize script in viewScript.
		wp_localize_script(
			'sm-api-block-sm-api-block-view-script',
			'smApiBlock',
			$sm_api_block_vars
		);
	}

	/**
	 * Register blocks.
	 *
	 * @since 1.0.0
	 *
	 * @todo There should be a better way to localize scripts for specific block.
	 *
	 * @return void
	 */
	public function register_blocks() {

		// Automatically load blocks.
		foreach ( glob( SM_API_BLOCK_PATH_BLOCKS . '*', GLOB_ONLYDIR ) as $block ) {

			// WP Register block.
			register_block_type( $block );

			// Add block support.
			$this->maybe_add_block_support( $block );
		}
	}
}
