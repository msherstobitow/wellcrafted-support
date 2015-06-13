<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! defined( 'WELLCRAFTED_SUPPORT' ) ) {
    define( 'WELLCRAFTED_SUPPORT', 'wellcrafted_support' );
}

class Wellcrafted_Support extends Wellcrafted_Plugin  {

    use Wellcrafted_Singleton_Trait;

    protected $use_styles = true;
    protected $use_scripts = true;

    public function init() {
        new Wellcrafted_Support_Request_Post_Type();
        new Wellcrafted_Support_Request_Theme_Taxonomy();
    }

} 
