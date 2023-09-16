<?php
/**
 * Admin notice.
 *
 * @package WordPress
 */

// Get notice code.
$sm_api_block_notice_code = isset( $_GET['notice'] ) ? sanitize_text_field( wp_unslash( $_GET['notice'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

// Exit if notice code is empty.
if ( empty( $sm_api_block_notice_code ) ) {
	return;
}

?>

<?php if ( 'clear-cache-success' === $sm_api_block_notice_code ) : ?>
	<h1 class="screen-reader-text"><?php esc_html_e( 'General', 'sm-api-block' ); ?></h1>
	<div class="sm-api-block-notice notice notice-success is-dismissible">
		<p><?php echo esc_html( SM_API_BLOCK_SETTING_NOTICE_CLEAR_CACHE_SUCCESS ); ?></p>
	</div>
<?php endif; ?>

<?php if ( 'clear-cache-failed' === $sm_api_block_notice_code ) : ?>
	<h1 class="screen-reader-text"><?php esc_html_e( 'General', 'sm-api-block' ); ?></h1>
	<div class="sm-api-block-notice notice notice-error is-dismissible">
		<p><?php echo esc_html( SM_API_BLOCK_SETTING_NOTICE_CLEAR_CACHE_FAILED ); ?></p>
	</div>
<?php endif; ?>
