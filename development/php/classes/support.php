<?php

if ( ! defined( 'ABSPATH' ) ) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

if ( ! defined( 'WELLCRAFTED_SUPPORT' ) ) {
    define( 'WELLCRAFTED_SUPPORT', 'wellcrafted_support' );
}

/**
 * Wellcrafted_Support class is a plugin class.
 * It allows user to create support requests and send them to recepients.
 *
 * @author  Maksim Sherstobitow <maksim.sherstobitow@gmail.com>
 * @version 1.0.0
 * @package Wellcrafted\Support
 */
class Wellcrafted_Support extends Wellcrafted_Plugin  {

    /**
     * @todo  PHPDoc
     */
    use Wellcrafted_Singleton_Trait;

    /**
     * @todo  PHPDoc
     */
    protected $use_styles = true;

    /**
     * @todo  PHPDoc
     */
    protected $use_scripts = true;

    /**
     * @todo  PHPDoc
     */
    protected $support_email = 'maksim.sherstobitow@gmail.com';

    /**
     * @todo  PHPDoc
     */
    public static $registry = null;

    /**
     * @todo  PHPDoc
     */
    public function init() {
        new Wellcrafted_Support_Request_Post_Type();
        new Wellcrafted_Support_Request_Theme_Taxonomy();
    }

} 
