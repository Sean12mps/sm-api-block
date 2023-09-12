<?php
/**
 * Endpoint helper model.
 *
 * @package WordPress
 */

/**
 * Handle the endpoint helper model.
 *
 * @since 1.0.0
 */
class Sm_Api_Block_Model_Endpoint {

	/**
	 * Headers.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	public $headers;

	/**
	 * Status.
	 *
	 * @since 1.0.0
	 *
	 * @var int
	 */
	public $status;

	/**
	 * Body.
	 *
	 * @since 1.0.0
	 *
	 * @var array
	 */
	public $body;

	/**
	 * Get default response status.
	 *
	 * @since 1.0.0
	 *
	 * @return integer
	 */
	public function get_response_status() {

		// Default status.
		$default_status = 503;

		// Get status.
		$status = $this->status ? $this->status : $default_status;

		// Return status.
		return $status;
	}

	/**
	 * Set response status.
	 *
	 * @since 1.0.0
	 *
	 * @param integer $status Response status code.
	 *
	 * @return integer
	 */
	public function set_response_status( $status ) {

		// Set status.
		$this->status = $status;

		// Return status.
		return $this->status;
	}

	/**
	 * Get default response headers.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_response_headers() {

		// Default headers.
		$default_headers = array(
			'Content-Type' => 'application/json',
		);

		// Get headers.
		$headers = wp_parse_args( $this->headers, $default_headers );

		// Return headers.
		return $headers;
	}

	/**
	 * Set response headers.
	 *
	 * @since 1.0.0
	 *
	 * @param array $headers Response headers.
	 *
	 * @return array
	 */
	public function set_response_headers( $headers = array() ) {

		// Set headers.
		$this->headers = $headers;

		// Return headers.
		return $this->headers;
	}

	/**
	 * Get default response body.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function get_response_body() {

		// Default body.
		$default_body = array(
			'data' => array(),
		);

		// Get body.
		$body = $this->body ? $this->body : $default_body;

		// Return body.
		return $body;
	}

	/**
	 * Set response body.
	 *
	 * @since 1.0.0
	 *
	 * @param array $body Response body.
	 *
	 * @return array
	 */
	public function set_response_body( $body = array() ) {

		// Set body.
		$this->body = $body;

		// Return body.
		return $this->body;
	}

	/**
	 * Send response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Response data.
	 *                    - status  (int)    Response status code.
	 *                    - headers (array)  Response headers.
	 *                    - data    (string) Response body.
	 *
	 * @return WP_HTTP_Response
	 */
	public function respond( $data = array() ) {

		// Default data.
		$data = wp_parse_args(
			$data,
			array(
				'status'  => $this->get_response_status(),
				'headers' => $this->get_response_headers(),
				'data'    => $this->get_response_body(),
			)
		);

		// Create http response object.
		$http_response = new WP_HTTP_Response();

		// Setup response.
		$http_response->set_status( $data['status'] );
		$http_response->set_headers( $data['headers'] );
		$http_response->set_data( $data['data'] );

		// Return response.
		return $http_response;
	}
}
