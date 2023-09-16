<?php
/**
 * Admin page.
 *
 * @package WordPress
 */

// Get current user.
$sm_api_block_current_user = wp_get_current_user();

// Submenu.
$sm_api_block_submenu_items = array(
	'general' => array(
		'page_title'   => __( 'General', 'sm-api-block' ),
		'menu_title'   => __( 'General', 'sm-api-block' ),
		'description'  => __( 'Display general information for the API block plugin.', 'sm-api-block' ),
		'capabilities' => array( 'author', 'editor', 'administrator' ),
		'template'     => 'page-home',
	),
	'cache'   => array(
		'page_title'   => __( 'Cache', 'sm-api-block' ),
		'menu_title'   => __( 'Cache', 'sm-api-block' ),
		'description'  => __( 'The data you received via API is cached by WordPress transient feature. You can be sure that we are not using anymore resources that we have to.', 'sm-api-block' ),
		'capabilities' => array( 'editor', 'administrator' ),
		'template'     => 'page-cache',
	),
);

// Get tab from query string.
$sm_api_block_current_tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'general'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended

// Base url.
$sm_api_block_base_url = admin_url( 'admin.php?page=sm-api-block' );

// Current template to render.
$sm_api_block_current_item =
	isset( $sm_api_block_submenu_items[ $sm_api_block_current_tab ] )
	?
	$sm_api_block_submenu_items[ $sm_api_block_current_tab ]
	:
	$sm_api_block_submenu_items['general'];

?>
<!-- Admin wrap -->
<div class="wrap" id="sm-api-block-admin-page">

	<!-- Submenu -->
	<div class="sm-api-block-admin-page-title">

		<?php foreach ( $sm_api_block_submenu_items as $sm_api_block_page_slug => $sm_api_block_submenu_item ) : ?>

			<?php $sm_api_block_tab_active = $sm_api_block_current_tab === $sm_api_block_page_slug ? 'active' : ''; ?>

			<a
				href="<?php echo esc_url( add_query_arg( 'tab', $sm_api_block_page_slug, $sm_api_block_base_url ) ); ?>"
				class="sm-api-block-admin-page-title-item <?php echo esc_attr( $sm_api_block_tab_active ); ?>"
			>
				<?php echo esc_html( $sm_api_block_submenu_item['menu_title'] ); ?>
			</a>
		<?php endforeach; ?>
	</div>

	<!-- Page content -->
	<div class="sm-api-block-admin-page-content">

		<?php if ( array_intersect( $sm_api_block_current_item['capabilities'], $sm_api_block_current_user->roles ) ) : ?>

			<?php require SM_API_BLOCK_PATH_INCLUDES . '/admin/notice.php'; ?>

			<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">

				<input type="hidden" name="action" value="<?php echo esc_attr( SM_API_BLOCK_SETTING_ACTION_NAME ); ?>">

				<?php wp_nonce_field( SM_API_BLOCK_SETTING_ACTION_NAME, SM_API_BLOCK_SETTING_NONCE_NAME ); ?>

				<div class="sm-api-block-setting-row sm-api-block-clear section-heading">
					<div class="sm-api-block-setting-field">
						<h2><?php echo esc_attr( $sm_api_block_current_item['page_title'] ); ?></h2>
						<p class="desc"><?php echo esc_attr( $sm_api_block_current_item['description'] ); ?></p>
					</div>
				</div>

				<?php require_once SM_API_BLOCK_PATH_INCLUDES . '/admin/' . $sm_api_block_current_item['template'] . '.php'; ?>
			</form>

		<?php else : ?>

			<?php $sm_api_block_needed_capabilities = $sm_api_block_current_item['capabilities']; ?>

			<?php require_once SM_API_BLOCK_PATH_INCLUDES . '/admin/page-incapable.php'; ?>
		<?php endif; ?>
	</div>
</div>
