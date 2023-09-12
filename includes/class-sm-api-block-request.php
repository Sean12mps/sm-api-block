<?php
/**
 * Request class.
 *
 * @package WordPress
 */

/**
 * Manage the request functionality.
 *
 * @since 1.0.0
 */
class Sm_Api_Block_Request {

	/**
	 * Request URL.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $url;

	/**
	 * Request method.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $method;

	/**
	 * Request headers.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	public $headers;

	/**
	 * Request body.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	public $body;

	/**
	 * Transient name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $transient_name;

	/**
	 * Transient time.
	 *
	 * @since 1.0.0
	 *
	 * @var int
	 */
	public $transient_time;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param string $url             Request URL.
	 * @param array  $args            Request arguments.
	 *                                - array  $headers  Request headers.
	 *                                - array  $body     Request body.
	 * @param string $transient_name  Transient name.
	 * @param int    $transient_time  Transient time.
	 *
	 * @return void
	 */
	public function __construct( $url, $args = array(), $transient_name = '', $transient_time = 1 * HOUR_IN_SECONDS ) {

		// Default args.
		$default_args = array(
			'method'  => 'GET',
			'headers' => $this->get_default_headers(),
			'body'    => array(),
		);

		// Merge args.
		$args = wp_parse_args( $args, $default_args );

		// Set request info.
		$this->url            = $url;
		$this->method         = $args['method'];
		$this->headers        = $args['headers'];
		$this->body           = $args['body'];
		$this->transient_name = $transient_name;
		$this->transient_time = $transient_time;
	}

	/**
	 * Default headers.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	private function get_default_headers() {

		// Default headers.
		$default_headers = array(
			'Content-Type' => 'application/json',
		);

		// Return default headers.
		return $default_headers;
	}

	/**
	 * Get the request data.
	 *
	 * @since 1.0.0
	 *
	 * @param bool   $format           Format response.
	 * @param string $check_transient  Check transient use.
	 *
	 * @return array
	 */
	public function get_request_response_body( $format = true, $check_transient = '' ) {

		// Check transient.
		if ( $check_transient ) {

			// Get transient.
			$transient = get_transient( $this->transient_name );

			// Check transient.
			if ( $transient ) {

				// Return transient.
				return $transient;
			}
		}

		// Request URL.
		$request_url = $this->url;

		// Request arguments.
		$request_args = array(
			'method'  => $this->method,
			'headers' => $this->headers,
		);

		// Add body if exists.
		if ( $this->body ) {
			$request_args['body'] = $this->body;
		}

		// Do request.
		$response = wp_remote_request( $request_url, $request_args );

		// Get response body.
		$response_body = wp_remote_retrieve_body( $response );

		// Format response.
		if ( $response_body && $format ) {

			// Decode response body.
			$response_body = json_decode( $response_body, true );
		}

		// If response is valid and transient name exists.
		if ( $response_body && $check_transient ) {

			// Set transient.
			set_transient( $this->transient_name, $response_body, $this->transient_time );
		}

		// Return response.
		return $response_body;
	}
}
