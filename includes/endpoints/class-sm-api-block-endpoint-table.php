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
		$route_namespace = apply_filters( SM_API_BLOCK_FILTER_ROUTE_TABLE_NAMESPACE, $this->slug );

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
				'args'                => array(
					'columns' => array(
						'validate_callback' => function ( $param ) {
							return is_array( $param );
						},
						'sanitize_callback' => function ( $param ) {
							return array_map( 'sanitize_text_field', $param );
						},
					),
				),
			)
		);
	}

	/**
	 * Filter data by column names.
	 *
	 * @since 1.0.0
	 *
	 * @param array $table_data  The data to be filtered.
	 * @param array $columns     The columns to be filtered.
	 *
	 * @return array | false
	 */
	public function filter_data_by_columns( $table_data, $columns ) {

		// Get index of each $columns value in $table_data['headers'].
		$indexes = array_map(
			function ( $value ) use ( $table_data ) {
				return array_search( $value, $table_data['headers'], true );
			},
			$columns
		);

		// Check if there is a false value in $indexes.
		if ( in_array( false, $indexes, true ) ) {
			return false;
		}

		// Loop table data headers and filter by $indexes.
		$_table_headers = array_filter(
			$table_data['headers'],
			function ( $value, $key ) use ( $indexes ) {
				return in_array( $key, $indexes, true );
			},
			ARRAY_FILTER_USE_BOTH
		);

		// Reset array keys.
		$table_headers = array_values( $_table_headers );

		// Filter data rows by order of $indexes.
		$table_rows = array_map(
			function ( $row_values ) use ( $indexes ) {

				$new_row_values = array();

				$i = 0;

				foreach ( $row_values as $key => $value ) {
					if ( in_array( $i, $indexes, true ) ) {
						$new_row_values[ $key ] = $value;
					}

					$i++;
				}

				return $new_row_values;
			},
			$table_data['rows']
		);

		// Modify the response.
		return array(
			'headers' => $table_headers,
			'rows'    => $table_rows,
		);
	}

	/**
	 * Callback.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_REST_Request $request The request object.
	 *
	 * @return array
	 */
	public function callback( $request ) {

		// Get the request URL.
		$request_url = apply_filters(
			SM_API_BLOCK_FILTER_ROUTE_TABLE_URL,
			SM_API_BLOCK_TABLE_ENDPOINT_URL
		);

		// Default request args.
		$default_args = array(
			'method' => 'GET',
		);

		// Get the request args.
		$request_args = apply_filters( SM_API_BLOCK_FILTER_ROUTE_TABLE_ARGS, $default_args );

		// Get the transient name.
		$transient_name = apply_filters(
			SM_API_BLOCK_FILTER_ROUTE_TABLE_TRANSIENT_NAME,
			SM_API_BLOCK_TRANSIENT_ROUTE_TABLE_NAME
		);

		// Get the transient expiration.
		$transient_expiration = apply_filters(
			SM_API_BLOCK_FILTER_ROUTE_TABLE_TRANSIENT_EXPIRATION,
			SM_API_BLOCK_TRANSIENT_ROUTE_TABLE_EXPIRATION
		);

		// Create the request.
		$request_manager = new Sm_Api_Block_Request(
			$request_url,
			$request_args,
			$transient_name,
			$transient_expiration
		);

		// Do and get the response.
		$response = $request_manager->get_request_response_body( true, $transient_name );

		// If there is an error, return the error.
		if ( is_wp_error( $response ) || ! $response ) {

			// Set the response status.
			$this->set_response_status( 400 );
		} else {

			// Set the response status.
			$this->set_response_status( 200 );

			// Get the columns.
			$columns = $request->get_param( 'columns' );

			// If columns exists, return data filtered by columns.
			if ( $columns ) {
				$table_data = $response['data'];

				$filtered_data = $this->filter_data_by_columns( $table_data, $columns );

				// Check if there is a false value in $indexes.
				if ( ! $filtered_data ) {

					// Set the response status.
					$this->set_response_status( 400 );

					// Set the response body.
					$this->set_response_body(
						array(
							'error' => SM_API_BLOCK_API_ERROR_INVALID_PARAMETER,
						)
					);

					// Return the response.
					return $this->respond();
				}

				// Modify the response.
				$response['filtered_data'] = $filtered_data;
			}
		}

		// Get the table data.
		$table_data = $this->set_response_body(
			array(
				'data' => $response,
			)
		);

		// Return the table data.
		return $this->respond();
	}
}
