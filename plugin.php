<?php
/**
 * Plugin Name: Unpublish Media Endpoint
 * Plugin URI: https://github.com/rahulsprajapati/unpublish-media-endpoint
 * Description: This plugin will enable media endpoint in case of the post it was uploaded from ( set as post parent ) is no longer in publish status, to fix issue of not able to use it in another post REST endpoint as featured image. Core ticket: https://core.trac.wordpress.org/ticket/41445
 * Author: Rahul Prajapati
 * Version: 1.0.0
 * Author URI: https://github.com/rahulsprajapati
 * License: GPL2+
 * Text Domain: unpublish-media-endpoint
 * Domain Path: /languages
 *
 * @package unpublish-media-endpoint
 */

namespace Unpublish_Media_Endpoint;

const VERSION = '0.0.1';

require_once __DIR__ . '/inc/class-attachment-controller.php';
require_once __DIR__ . '/inc/namespace.php';
bootstrap();
