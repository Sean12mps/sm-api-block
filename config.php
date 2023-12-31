<?php
/**
 * Plugin configurations.
 *
 * @package WordPress
 */

// Includes path.
define( 'SM_API_BLOCK_PATH_INCLUDES', plugin_dir_path( __FILE__ ) . 'includes/' );

// Assets path.
define( 'SM_API_BLOCK_PATH_ASSETS', plugin_dir_url( __FILE__ ) . 'assets/' );

// Configs path.
define( 'SM_API_BLOCK_PATH_CONFIGS', plugin_dir_path( __FILE__ ) . 'configs/' );

// Enpoints path.
define( 'SM_API_BLOCK_PATH_ENDPOINTS', SM_API_BLOCK_PATH_INCLUDES . 'endpoints/' );

// Models path.
define( 'SM_API_BLOCK_PATH_MODELS', SM_API_BLOCK_PATH_INCLUDES . 'models/' );

// Block path.
define( 'SM_API_BLOCK_PATH_BLOCKS', plugin_dir_path( __FILE__ ) . 'build/' );

// Load config files.
require_once SM_API_BLOCK_PATH_CONFIGS . 'texts.php';
require_once SM_API_BLOCK_PATH_CONFIGS . 'filters.php';
