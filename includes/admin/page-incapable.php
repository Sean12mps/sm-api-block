<?php
/**
 * Error capabilties.
 *
 * @package WordPress
 */

?>

<div class="sm-api-block-setting-row sm-api-block-clear section-heading">
	<div class="sm-api-block-setting-field">
		<h2><?php esc_html_e( 'Unsupported User Role', 'sm-api-block' ); ?></h2>
		<p class="desc"><?php esc_html_e( 'Your current user role does not have the capability to edit this section of the plugin setting.', 'sm-api-block' ); ?></p>
	</div>
</div>
<div class="sm-api-block-setting-row sm-api-block-clear">
	<div class="sm-api-block-setting-label">
		<label for=""><?php esc_html_e( 'Expected Capabilities', 'sm-api-block' ); ?></label>
	</div>
	<div class="sm-api-block-setting-field">
		<p><?php esc_html_e( 'To access this section, your user need to have at least one of these roles:', 'sm-api-block' ); ?></p>
		<ul class="list-role">
			<?php foreach ( $sm_api_block_needed_capabilities as $sm_api_block_needed_capability ) : ?>
				<li><?php echo esc_attr( $sm_api_block_needed_capability ); ?></li>
			<?php endforeach; ?>
		</ul>
		<p class="desc"><?php esc_html_e( 'To gain access, please refer to your site\'s administrator to be assigned the appropriate role as mentioned above.' ) ?></p>
	</div>
</div>
