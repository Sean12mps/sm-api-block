<?php
/**
 * Block render file.
 *
 * @package WordPress
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Parent class name.
$sm_api_block_parent_class_name = $attributes['parentClass'];

// Class attributes.
$sm_api_block_attr_class = wp_sprintf( 'class="%s"', esc_attr( $sm_api_block_parent_class_name ) );

// Get attribute columns.
$sm_api_block_columns = $attributes['activeColumns'];

// JSON encode columns.
$sm_api_block_columns_json = implode( ',', $sm_api_block_columns );

// Set data columns attribute.
$sm_api_block_attr_data_columns = wp_sprintf( 'data-columns="%s"', esc_attr( $sm_api_block_columns_json ) );

?>
<div <?php echo get_block_wrapper_attributes(); //phpcs:ignore ?>>

	<div
		<?php echo $sm_api_block_attr_class; //phpcs:ignore ?>
		<?php echo $sm_api_block_attr_data_columns; //phpcs:ignore ?>
	></div>
</div>
