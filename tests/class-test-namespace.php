<?php
/**
 * Test for Plugin.
 *
 * @package unpublish-media-endpoint
 */

namespace Unpublish_Media_Endpoint\Tests;

use WP_UnitTestCase;

/**
 * Unpublish_Media_Endpoint test case.
 */
class Unpublish_Media_Endpoint extends WP_UnitTestCase {
	
	/**
	 * Test bootstrap.
	 */
	public function test_bootstrap() {
		$this->assertEquals( 10, has_action( 'plugins_loaded', 'Unpublish_Media_Endpoint\\load_textdomain' ) );
	}

}
