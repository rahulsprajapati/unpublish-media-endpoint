<?php
/**
 * Attachment_Controller for customize media endpoint.
 *
 * @package unpublish-media-endpoint
 */

namespace Unpublish_Media_Endpoint;

use WP_REST_Attachments_Controller;

/**
 * Class Attachment_Controller
 */
class Attachment_Controller extends WP_REST_Attachments_Controller {

	/**
	 * Override function WP_REST_Posts_Controller->check_read_permission()
	 *
	 * Checks if a post can be read. Correctly handles posts with the inherit status.
	 * Note: Removed inherit check for attachment which is blocking access of
	 * media endpoint for other post in which it's used.
	 *
	 * @see https://core.trac.wordpress.org/ticket/41445
	 *
	 * @param \WP_Post $post Post object.
	 *
	 * @return bool Whether the post can be read.
	 */
	public function check_read_permission( $post ) {
		$post_type = get_post_type_object( $post->post_type );

		if ( ! $this->check_is_post_type_allowed( $post_type ) ) {
			return false;
		}

		// Is the post readable?
		if ( 'publish' === $post->post_status || current_user_can( $post_type->cap->read_post, $post->ID ) ) {
			return true;
		}

		$post_status_obj = get_post_status_object( $post->post_status );

		if ( $post_status_obj && $post_status_obj->public ) {
			return true;
		}

		/**
		 * If there isn't a parent, but the status is set to inherit, assume
		 * it's published (as per get_post_status()).
		 */
		if ( 'inherit' === $post->post_status ) {
			return true;
		}

		return false;
	}
}
