<?php
/**
 * Trait for mock user data in tests.
 *
 * @package unpublish-media-endpoint
 */

namespace Unpublish_Media_Endpoint\Tests;

use Spy_REST_Server;
use WP_Test_REST_TestCase;

/**
 * Class REST_Controller_Testcase
 *
 * @package Unpublish_Media_Endpoint\Tests
 */
abstract class REST_Controller_Testcase extends WP_Test_REST_TestCase {

	/**
	 * Instance of a test-specific REST server.
	 *
	 * @var Spy_REST_Server
	 */
	protected $server;

	/**
	 * Setup before tests.
	 */
	public function setUp() {
		parent::setUp();
	
		add_filter( 'rest_url', [ $this, 'filter_rest_url_for_leading_slash' ], 10, 2 );

		/**
		 * Rest server for testing.
		 *
		 * @var \WP_REST_Server $wp_rest_server
		 */
		global $wp_rest_server;

		// @codingStandardsIgnoreLine - This assignment cannot be the first block of code.
		$this->server = $wp_rest_server = new Spy_REST_Server;
		
		do_action( 'rest_api_init' );
	}

	/**
	 * Tear down after tests.
	 */
	public function tearDown() {
		parent::tearDown();

		remove_filter( 'rest_url', [ $this, 'test_rest_url_for_leading_slash' ], 10, 2 );

		/**
		 * Rest server for testing.
		 *
		 * @var \WP_REST_Server $wp_rest_server
		 */
		global $wp_rest_server;

		$wp_rest_server = null;
	}

	/**
	 * Work around core bug.
	 *
	 * This removes the erroneous assertion in core.
	 *
	 * @see https://core.trac.wordpress.org/ticket/42452
	 *
	 * @param string $url REST API URL.
	 * @param string $path REST API path.
	 *
	 * @return string Unchanged URL.
	 */
	public function filter_rest_url_for_leading_slash( $url, $path ) {
		return $url;
	}
}
