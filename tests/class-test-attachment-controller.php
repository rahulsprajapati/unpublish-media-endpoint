<?php
/**
 * Test for Plugin.
 *
 * @package unpublish-media-endpoint
 */

namespace Unpublish_Media_Endpoint\Tests;

use Unpublish_Media_Endpoint\Attachment_Controller;
use Unpublish_Media_Endpoint\Tests\REST_Controller_Testcase;
use WP_REST_Request;

/**
 * Test_Attachment_Controller test case.
 */
class Test_Attachment_Controller extends REST_Controller_Testcase {

	/**
	 * Post id where media attached.
	 *
	 * @var array
	 */
	protected static $post_id;

	/**
	 * Media attachment id.
	 *
	 * @var array
	 */
	protected static $attachment_id_1;

	/**
	 * Media attachment id.
	 *
	 * @var array
	 */
	protected static $attachment_id_2;

	/**
	 * Setup required WP data for tests.
	 */
	public static function wpSetUpBeforeClass() {
		
		self::$post_id = self::factory()->post->create(
			[
				'post_type'   => 'post',
				'post_status' => 'publish',
			]
		);

		self::$attachment_id_1 = self::factory()->attachment->create(
			[
				'post_parent' => self::$post_id,
			]
		);

		self::$attachment_id_2 = self::factory()->attachment->create();

		register_post_status(
			'test-publish',
			[
				'label'  => 'Test Published',
				'public' => true,
			]
		);
	}

    /**
     * Test for REST API endpoint for unpublished post.
     *
     * @return void
     */
    public function test_check_read_permission() {
		$instance = new Attachment_Controller( 'attachment' );

		$post = get_post( self::$post_id );

		$post->post_type = 'invalid';
		$this->assertFalse( $instance->check_read_permission( $post ) );

		$post->post_type = 'post';
		$this->assertTrue( $instance->check_read_permission( $post ) );

		$post->post_status = 'test-publish';
		$this->assertTrue( $instance->check_read_permission( $post ) );

		$post->post_status = 'draft';
		$this->assertFalse( $instance->check_read_permission( $post ) );

		$post->post_status = 'publish';
		$attachment_obj = get_post( self::$attachment_id_1 );

		$this->assertTrue( $instance->check_read_permission( $attachment_obj ) );
    }

	/**
	 * Test to check all attachment endpoint works as expected.
	 */
	public function test_endpoint_access() {

		$request = new WP_REST_Request( 'GET', '/wp/v2/media/' . self::$attachment_id_1 );
		$response = rest_ensure_response( $this->server->dispatch( $request ) );
		$this->assertEquals( 200, $response->get_status() );

		$request = new WP_REST_Request( 'GET', '/wp/v2/media/' . self::$attachment_id_2 );
		$response = rest_ensure_response( $this->server->dispatch( $request ) );
		$this->assertEquals( 200, $response->get_status() );

		wp_update_post(
			[
				'ID'          => self::$post_id,
				'post_status' => 'draft',
			]
		);

		$request  = new WP_REST_Request( 'GET', '/wp/v2/media/' . self::$attachment_id_1 );
		$response = rest_ensure_response( $this->server->dispatch( $request ) );
		$this->assertEquals( 200, $response->get_status() );

		$request  = new WP_REST_Request( 'GET', '/wp/v2/media/' . self::$attachment_id_2 );
		$response = rest_ensure_response( $this->server->dispatch( $request ) );
		$this->assertEquals( 200, $response->get_status() );
	}
}
