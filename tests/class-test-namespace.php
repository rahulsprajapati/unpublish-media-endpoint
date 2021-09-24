<?php
/**
 * Test for Plugin.
 *
 * @package unpublish-media-endpoint
 */

namespace Unpublish_Media_Endpoint\Tests;

use Unpublish_Media_Endpoint;
use WP_UnitTestCase;

/**
 * Unpublish_Media_Endpoint test case.
 */
class Test_Unpublish_Media_Endpoint extends WP_UnitTestCase {
	
	/**
	 * Test bootstrap.
	 */
	public function test_bootstrap() {
		Unpublish_Media_Endpoint\bootstrap();

		$this->assertEquals( 10, has_action( 'plugins_loaded', 'Unpublish_Media_Endpoint\\load_textdomain' ) );
		$this->assertEquals( 10, has_filter( 'register_post_type_args', 'Unpublish_Media_Endpoint\\filter_attachment_post_type_args' ) );
	}

	/**
	 * Test case for filter_attachment_post_type_args function.
	 * 
	 * @return void
	 */
	public function test_filter_attachment_post_type_args() {
		$test_args = [
			'description'           => '',
			'public'                => false,
			'hierarchical'          => false,
			'rest_base'             => 'media',
			'rest_controller_class' => 'WP_REST_Attachments_Controller',
			'supports'              => [
				'title',
				'summary',
			],
		];

		$filtered_args = Unpublish_Media_Endpoint\filter_attachment_post_type_args( $test_args, 'post' );

		$this->assertEquals(
			'WP_REST_Attachments_Controller',
			$filtered_args['rest_controller_class']
		);

		$filtered_args = Unpublish_Media_Endpoint\filter_attachment_post_type_args( $test_args, 'attachment' );

		$this->assertEquals(
			'\\Unpublish_Media_Endpoint\\Attachment_Controller',
			$filtered_args['rest_controller_class']
		);
	}

	/**
	 * Test for attachment post type args.
	 *
	 * @return void
	 */
	public function test_registered_attachment_post_type() {

		$attachment_post_type = get_post_type_object( 'attachment' );
		
		$this->assertEquals( $attachment_post_type->rest_controller_class, '\\Unpublish_Media_Endpoint\\Attachment_Controller' );
	}
}
