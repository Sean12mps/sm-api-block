<?php
/**
 * Texts configurations.
 *
 * @package WordPress
 */

// Plugin name.
define( 'SM_API_BLOCK_PLUGIN_NAME', 'Sean Michael - API Block Challenge' );

// Plugin version.
define( 'SM_API_BLOCK_VERSION', '1.0.0' );

// Plugin text domain.
define( 'SM_API_BLOCK_SLUG', 'sm-api-block' );

// Table endpoint URL.
define( 'SM_API_BLOCK_TABLE_ENDPOINT_URL', 'https://miusage.com/v1/challenge/1/' );

// Transient route table name.
define( 'SM_API_BLOCK_TRANSIENT_ROUTE_TABLE_NAME', 'sm_api_block_transient_route_table_name' );

// Transient route table expiration. Default 1 hour.
define( 'SM_API_BLOCK_TRANSIENT_ROUTE_TABLE_EXPIRATION', 1 * HOUR_IN_SECONDS );

// Setting action name.
define( 'SM_API_BLOCK_SETTING_ACTION_NAME', 'sm_api_block_form_submission' );

// Setting nonce name.
define( 'SM_API_BLOCK_SETTING_NONCE_NAME', 'sm_api_block_setting_form_nonce_xyz' );

// Setting display header.
define( 'SM_API_BLOCK_SETTING_DISPLAY_HEADER', __( 'API Block Challenge', 'sm-api-block' ) );

// Setting notice clear cache success.
define( 'SM_API_BLOCK_SETTING_NOTICE_CLEAR_CACHE_SUCCESS', __( 'API cache cleared.', 'sm-api-block' ) );

// Setting notice clear cache failed.
define( 'SM_API_BLOCK_SETTING_NOTICE_CLEAR_CACHE_FAILED', __( 'API cache could not be cleared.', 'sm-api-block' ) );

// Notice error not sufficient permissions.
define( 'SM_API_BLOCK_NOTICE_ERROR_NOT_SUFFICIENT_PERMISSIONS', __( 'You do not have sufficient permissions to access this page.', 'sm-api-block' ) );

// API Error invalid parameter.
define( 'SM_API_BLOCK_API_ERROR_INVALID_PARAMETER', __( 'Invalid parameter.', 'sm-api-block' ) );
