<?php
/**
 * Admin page: general.
 *
 * @package WordPress
 */

// Get transient value.
$sm_api_block_transient_value = get_transient( SM_API_BLOCK_TRANSIENT_ROUTE_TABLE_NAME );

?>
<div class="sm-api-block-setting-row sm-api-block-clear">
	<div class="sm-api-block-setting-label">
		<label for=""><?php esc_html_e( 'API Data', 'sm-api-block' ); ?></label>
	</div>
	<div class="sm-api-block-setting-field">
		<p><?php esc_html_e( 'The API data.', 'sm-api-block' ); ?></p>
		<p class="desc"><?php esc_html_e( 'Shows the API data that is being cached.', 'sm-api-block' ); ?></p>
		<p>
			<?php if ( $sm_api_block_transient_value ) : ?>
				<?php
				// Change value to JSON and pretty print.
				$sm_api_block_json_pretty  = wp_json_encode( $sm_api_block_transient_value, JSON_PRETTY_PRINT );
				$sm_api_block_lines_arr    = preg_split( '/\n|\r/', $sm_api_block_json_pretty );
				$sm_api_block_num_newlines = count( $sm_api_block_lines_arr );
				?>
				<textarea class="transient-value" rows="<?php echo esc_attr( $sm_api_block_num_newlines ); ?>" disabled><?php echo $sm_api_block_json_pretty; // phpcs:ignore. ?></textarea>

			<?php else : ?>

				<textarea class="transient-value" rows="<?php echo esc_attr( $sm_api_block_num_newlines ); ?>" disabled><?php esc_html_e( 'No data found.', 'sm-api-block' ); ?></textarea>
			<?php endif; ?>
		</p>
	</div>
</div>
