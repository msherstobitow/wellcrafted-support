<?php
/**
 * Plugin Name: Wellcrafted Support
 * Plugin URI: http://msherstobitow.com/plugins/wellcraftedcore
 * Description: --
 * Version: 1.0
 * Author: Maksim Sherstobitow
 * Author URI: http://msherstobitow.com
 * License: GPL2
 */ 
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'wellcrafted_core_initilized', function() {
    require 'classes/support.php';
    Wellcrafted_Support::instance()->init();
} );


