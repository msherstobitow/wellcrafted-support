<?php

class Wellcrafted_Support_Request_Theme_Taxonomy extends Wellcrafted_Admin_Taxonomy {

    protected $taxonomy = 'wc_support_request_tag';
    protected $object_type = 'wc_support_request';
    protected $show_admin_column = true;

    protected function set_params() {
        $this->name_label = __( 'Tags' );
        $this->singular_name_label = __( 'Tag' );
    }

}
