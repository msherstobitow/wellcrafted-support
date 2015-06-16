<?php

if ( ! defined( 'ABSPATH' ) ) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

/**
 * Wellcrafted_Support_Request_Theme_Taxonomy class object creates a 'wc_support_request_tag' admin taxonomy for 'wc_support_request' post type.
 * It uses just for tagging support requests.
 *
 * @author  Maksim Sherstobitow <maksim.sherstobitow@gmail.com>
 * @version 1.0.0
 * @package Wellcrafted\Support
 */
class Wellcrafted_Support_Request_Theme_Taxonomy extends Wellcrafted_Admin_Taxonomy {

    /**
     * @todo  PHPDoc
     */
    protected $taxonomy = 'wc_support_request_tag';

    /**
     * @todo  PHPDoc
     */
    protected $object_type = 'wc_support_request';

    /**
     * @todo  PHPDoc
     */
    protected $show_admin_column = true;

    /**
     * @todo  PHPDoc
     */
    protected function set_params() {
        $this->name_label = __( 'Tags' );
        $this->singular_name_label = __( 'Tag' );
    }

}
