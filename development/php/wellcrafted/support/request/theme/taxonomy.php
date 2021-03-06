<?php

namespace Wellcrafted\Support\Request\Theme;

if ( ! defined( 'ABSPATH' ) ) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

/**
 * Wellcrafted_Support_Request_Theme_Taxonomy class object creates a 'wc_supportrequesttag' admin taxonomy for 'wc_supportrequest' post type.
 * It uses just for tagging support requests.
 *
 * @author  Maksim Sherstobitow <maksim.sherstobitow@gmail.com>
 * @version 1.0.0
 * @package Wellcrafted\Support
 */
class Taxonomy extends \Wellcrafted\Core\Admin\Taxonomy {

    /**
     * The name of the taxonomy. Name should only contain lowercase letters and the underscore character, and not be more than 32 characters long (database structure restriction). 
     * 
     * @var string
     * @since  1.0.0
     */
    protected $taxonomy = 'wc_supportrequesttag';

    /**
     * Name of the object type for the taxonomy object. Object-types can be built-in Post Type or any Custom Post Type that may be registered. 
     * 
     * @var string or array
     * @since  1.0.0
     */
    protected $object_type = 'wc_supportrequest';

    /**
     * Whether to allow automatic creation of taxonomy columns on associated post-types table. (Available since 3.5) 
     * 
     * @var boolean
     * @since  1.0.0
     */
    protected $show_admin_column = true;

    /**
     * Allows to set params before normalizing
     * 
     * @since  1.0.0
     */
    protected function set_params() {
        $this->name_label = __( 'Tags', WELLCRAFTED_SUPPORT );
        $this->singular_name_label = __( 'Tag', WELLCRAFTED_SUPPORT );
    }

}
