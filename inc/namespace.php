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

	// Load plugin textdomain.
	add_action( 'plugins_loaded', __NAMESPACE__ . '\\load_textdomain' );
	
	// Update rest controller class for attachment post type.
	add_filter( 'register_post_type_args', __NAMESPACE__ . '\\filter_attachment_post_type_args', 10, 2 );
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
 * Override default post type attachment arguments.
 *
 * @param array  $args      Array of arguments for registering a post type.
 * @param string $post_type Post type name.
 *
 * @return array
 */
function filter_attachment_post_type_args( array $args, string $post_type ) : array {
	
	if ( $post_type !== 'attachment' ) {
		return $args;
	}

	$args['rest_controller_class'] = '\\Unpublish_Media_Endpoint\\Attachment_Controller';

	return $args;
}
