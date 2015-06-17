<?php
/**
 * Plugin Name: Wellcrafted Support
 * Plugin URI: http://msherstobitow.com/plugins/wellcraftedcore
 * Description: The plugin allows to send detailed support requests to themes/plugins authors.
 * Version: 1.0
 * Author: Maksim Sherstobitow
 * Author URI: http://msherstobitow.com
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */ 

/**
 * Wellcrafted Support initializer
 * 
 * @package Wellcrafted\Support
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

/**
 * Initilize the plugin on Wellcrafted Core action call.
 *
 * @since  1.0.0
 */
add_action( 'wellcrafted_core_initilized', function() {
    require 'classes/support.php';
    Wellcrafted_Support::instance()->init();
} );


