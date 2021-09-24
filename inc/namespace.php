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
