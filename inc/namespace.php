<?php
/**
 * Unpublish_Media_Endpoint Namespace.
 *
 * @package unpublish-media-endpoint
 */

namespace Unpublish_Media_Endpoint;

/**
 * Hook up all the filters and actions.
 */
function bootstrap() {

	// Bootstrap plugin functionality...
	add_action( 'plugins_loaded', __NAMESPACE__ . '\\load_textdomain' );
	add_action( 'plugins_loaded', __NAMESPACE__ . '\\activate_plugin' );

}

/**
 * Load plugin text domain for text translation.
 */
function load_textdomain() {

	load_plugin_textdomain(
		'unpublish-media-endpoint',
		false,
		basename( plugin_dir_url( __DIR__ ) ) . '/languages'
	);
}

/**
 * Dependency check before loading the plugin if any.
 */
function is_dependency_loaded() {

	return true;
}

/**
 * Load plugin functionality if dependency are loaded correctly.
 */
function activate_plugin() {

	if ( ! is_dependency_loaded() ) {
		add_action( 'admin_notices', __NAMESPACE__ . '\\dependency_admin_notice' );
		add_action( 'network_admin_notices', __NAMESPACE__ . '\\dependency_admin_notice' );
		return;
	}

	load_plugin();
}

/**
 * Plugin dependency error message for admin notice.
 */
function dependency_admin_notice() {
	
	echo '<div class="error"><p>';
	esc_html_e( 'Plugin can\'t be loaded, It requires following plugins to be installed and activated.', 'unpublish-media-endpoint' );
		echo '<ol>';
			printf(
				'<li><a href="https://wordpress.org/plugins/plugin-1" target="_blank">%s</a></li>',
				esc_html__( 'Plugin 1', 'unpublish-media-endpoint' )
			);
			printf(
				' <li><a href="https://wordpress.org/plugins/plugin-2" target="_blank">%s</a></li>',
				esc_html__( 'Plugin 2', 'unpublish-media-endpoint' )
			);
		echo '</ol>';
	esc_html_e( 'Please verify the dependency to enable this field type.', 'unpublish-media-endpoint' );
	echo '</p></div>';
}

/**
 * Load Plugin.
 */
function load_plugin() {

	add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\\admin_enqueue_scripts', 11 );
	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_scripts', 11 );
}

/**
 * Enqueue helper JS/CSS script in the admin.
 *
 * @param string $hook Hook for the current page in the admin.
 */
function admin_enqueue_scripts( $hook ) {

	if ( ! in_array( $hook, [ 'post.php', 'post-new.php' ], true ) ) {
		return;
	}

	wp_enqueue_style(
		'unpublish-media-endpoint-admin-css',
		plugin_dir_url( __FILE__ ) . 'assets/css/unpublish-media-endpoint-admin.css',
		[],
		VERSION
	);

	wp_enqueue_script(
		'unpublish-media-endpoint-admin-js',
		plugin_dir_url( __FILE__ ) . 'assets/js/unpublish-media-endpoint-admin.js',
		[
			'wp-util',
		],
		VERSION,
		true
	);
}

/**
 * Enqueue helper JS/CSS script.
 *
 * @param string $hook Hook for the current page in the admin.
 */
function enqueue_scripts( $hook ) {

	wp_enqueue_style(
		'unpublish-media-endpoint-css',
		plugin_dir_url( __FILE__ ) . 'assets/css/unpublish-media-endpoint.css',
		[],
		VERSION
	);

	wp_enqueue_script(
		'unpublish-media-endpoint-js',
		plugin_dir_url( __FILE__ ) . 'assets/js/unpublish-media-endpoint.js',
		[
			'wp-util',
		],
		VERSION,
		true
	);
}
