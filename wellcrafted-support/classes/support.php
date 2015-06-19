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
     * Add into a class Singleton pattern ability
     *
     * @since  1.0.0
     */
    use Wellcrafted_Singleton_Trait;

    /**
     * Whether to use plugin's style
     * 
     * The style should be placed at ./assets/css/admin-style.css
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $use_admin_style = true;

    /**
     * Whether to use plugin's script on backend
     * 
     * The script should be placed at ./assets/javascript/admin-script.js
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $use_admin_script = true;

    /**
     * A developer's support email. 
     * 
     * @since  1.0.0
     */
    protected $support_email = 'support_plugin.support@wllcrftd.com';

    /**
     * A variable to keep a Wellcrefted_Registry class in.
     * Note that each of child classes should define this variable to have a separate registry.
     * 
     * @var null
     * @since  1.0.0
     */
    public static $registry = null;

    /**
     * Init class object.
     *
     * @since  1.0.0
     */
    public function init() {
        new Wellcrafted_Support_Request_Post_Type();
        new Wellcrafted_Support_Request_Theme_Taxonomy();
    }

} 
