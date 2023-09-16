<?php
/**
 * Admin page: general.
 *
 * @package WordPress
 */

?>
<div class="sm-api-block-setting-row sm-api-block-clear">
	<div class="sm-api-block-setting-label">
		<label for=""><?php esc_html_e( 'Clear Cache', 'sm-api-block' ); ?></label>
	</div>
	<div class="sm-api-block-setting-field">
		<p><?php esc_html_e( 'Not sure if you\'re seeing the latest data? Relax!', 'sm-api-block' ); ?></p>
		<p><?php esc_html_e( 'You can force clear the cache and be sure that your API block is pulling the latest data from the API.', 'sm-api-block' ); ?></p>
		<p class="desc"><?php esc_html_e( 'Clear the cache by clicking on the Clear Cache button or use wp-cli command', 'sm-api-block' ); ?> <span class="code">wp sm-api-block clear-cache</span>.</p>
		<p>
			<button
				type="submit"
				class="sm-api-block-btn sm-api-block-btn-md sm-api-block-btn-red"
				name="submit"
				value="clear-cache"
			><?php esc_html_e( 'Clear Cache', 'sm-api-block' ); ?></button>
		</p>
	</div>
</div>
