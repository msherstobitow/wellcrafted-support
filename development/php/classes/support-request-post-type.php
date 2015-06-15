<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * @todo  PHPDoc
 */
class Wellcrafted_Support_Request_Post_Type extends Wellcrafted_Admin_Post_Type {

    protected $post_type = 'wc_support_request';
    protected $use_meta_boxes = true;

    protected function init() {
        if ( is_admin() ) {

            /**
             * Add admin notices if errors are exists
             */
            $sent_success = wellcrafted_array_value( $_GET, WELLCRAFTED_SUPPORT . '_request_sent' );
            $sent_errors = wellcrafted_array_value( $_GET, WELLCRAFTED_SUPPORT . '_error', [] );
            if ( is_array( $sent_errors ) && ! empty( $sent_errors ) ) {
                if ( in_array( WELLCRAFTED_SUPPORT . '_request_fill_sender', $sent_errors ) ) {
                    Wellcrafted_Admin_Notices::error( __( 'You should fill a sender email to send a request.', WELLCRAFTED_SUPPORT ) );
                }

                if ( in_array( WELLCRAFTED_SUPPORT . '_request_fill_receiver', $sent_errors ) ) {
                    Wellcrafted_Admin_Notices::error( __( 'You should fill a receiver email to send a request.', WELLCRAFTED_SUPPORT ) );
                }

                if ( in_array( WELLCRAFTED_SUPPORT . '_request_wasnt_sent', $sent_errors ) ) {
                    Wellcrafted_Admin_Notices::error( __( 'A request wasn\'t sent due to errors.', WELLCRAFTED_SUPPORT ) );
                }
            } else if ( $sent_success ) {
                Wellcrafted_Admin_Notices::updated( 
                    sprintf( 
                        '%s <b>%s</b>',
                        __( 'A request was successfully sent.', WELLCRAFTED_SUPPORT ),
                        __( 'It doesn\'t mean that the receiver will get the email.', WELLCRAFTED_SUPPORT ) 
                    )
                );
            }

            /**
             * Localize script for 'Publish' meta box
             */
            add_action( 'admin_enqueue_scripts', function() {
                Wellcrafted_Assets::localize_admin_script(
                    Wellcrafted_Support::registry()->plugin_system_name . '_base_admin_script', 
                    WELLCRAFTED_SUPPORT, 
                    [ 
                        'save' => __( 'Save', WELLCRAFTED_SUPPORT ),
                        'save-n-send' => __( 'Save&amp;Send', WELLCRAFTED_SUPPORT )
                    ]
                );
            }, 0);

            /**
             * Modify 'Publish' meta box
             */
            add_action( 'post_submitbox_misc_actions', function( $post_type ) {
                global $post, $post_type;

                if ( $this->post_type === $post_type ) {
                    $sent_requests_data = get_post_meta( $post->ID, '_' . WELLCRAFTED_SUPPORT . '_sent_requests_data' );
                    $saved = 'publish' === $post->post_status;
                    require Wellcrafted_Support::instance()->get_plugin_path() . '/views/send-request-meta-box.php';
                }
            }, 10, 3 );

        }

    }

    public function modify_columns( $columns ) {
        return wellcrafted_insert_to_array( 
            $columns, 
            'title', 
            array( WELLCRAFTED_SUPPORT . '_request_data' => __( 'Request data', WELLCRAFTED_SUPPORT ) )
        );
    }

    public function edit_column( $column, $post_id ) {
        switch ( $column ) {
            case WELLCRAFTED_SUPPORT . '_request_data':
                $request_data = get_post_meta( $post_id, '_' . WELLCRAFTED_SUPPORT . '_sent_requests_data', 1 );
                $request_options = get_post_meta( $post_id, '_' . WELLCRAFTED_SUPPORT, 1 );
                require Wellcrafted_Support::instance()->get_plugin_path() . '/views/list-column-data.php';
                break;
            default: break;
        }
    }

    /**
     * Set all required parameters for post type registration
     */
    protected function set_params() {
        $this->name_label = 'Support requests';
        $this->singular_name_label = __( 'Support', WELLCRAFTED_SUPPORT );
        $this->all_items_label = __( 'All requests', WELLCRAFTED_SUPPORT );
        $this->add_new_label = __( 'Create new', WELLCRAFTED_SUPPORT );
        $this->add_new_item_label = __( 'Create new request', WELLCRAFTED_SUPPORT );
        $this->new_item_label = __( 'New request', WELLCRAFTED_SUPPORT );
        $this->menu_name_label = __( 'Support', WELLCRAFTED_SUPPORT );
        $this->edit_item_label = __( 'Edit request', WELLCRAFTED_SUPPORT );
    }

    public function add_meta_boxes() {
        add_meta_box(
            WELLCRAFTED_SUPPORT . '_request_options',
            __( 'Request options', WELLCRAFTED_SUPPORT ),
            array( &$this, 'request_options_meta_box' ),
            $this->post_type,
            'normal'
        );

    }

    public function request_options_meta_box() {
        $this->render_nonce( WELLCRAFTED_SUPPORT . '_request_options_nonce' );

        global $post;
        $data = [];

        if ( property_exists( $post, 'ID' ) ) {
            $data = get_post_meta( $post->ID, '_' . WELLCRAFTED_SUPPORT, 1 );
        }

        $sender_name = wellcrafted_array_value( $data, 'sender_name', wp_get_current_user()->display_name );
        $sender_email = wellcrafted_array_value( $data, 'sender_email', wp_get_current_user()->user_email );
        $receiver_email = wellcrafted_array_value( $data, 'receiver_email' );
        $installed_themes = wp_get_themes([
                                'errors' => null
                            ]);

        $active_theme_name = wp_get_theme()->get( 'Name' );
        $chosen_plugins = wellcrafted_array_value( $data, 'plugins_data' );
        
        if ( ! is_array( $chosen_plugins ) ) {
            $chosen_plugins = [];
        }

        $installed_plugins = get_plugins();

        $developers_emails = [];

        if ( defined( 'THEME_DEVELOPER_EMAIL' ) ) {
            $developers_emails[ sprintf( __( '"%s" theme developer', WELLCRAFTED_SUPPORT ), $active_theme_name ) ] = THEME_DEVELOPER_EMAIL;
            $developers_emails = apply_filters( 'wellcrafted_support_developers_emails', $developers_emails );
        }

        require Wellcrafted_Support::instance()->get_plugin_path() . '/views/request-options-meta-box.php';
    }

    protected function save_meta_boxes_data() {
        if ( ! $this->check_nonce( WELLCRAFTED_SUPPORT . '_request_options_nonce' ) ) {
            return;
        }

        if ( ! isset( $_POST[ WELLCRAFTED_SUPPORT ] ) ) {
            return;
        }

        $data = $_POST[ WELLCRAFTED_SUPPORT ];

        $sender_name = isset( $data[ 'sender_name' ] ) ? sanitize_text_field( $data[ 'sender_name' ] ) : '';
        
        $sender_email = isset( $data[ 'sender_email' ] ) ? sanitize_text_field( $data[ 'sender_email' ] ) : '';
        $sender_email = filter_var( $sender_email, FILTER_SANITIZE_EMAIL );

        if ( filter_var( $sender_email, FILTER_VALIDATE_EMAIL ) === false ) {
            $sender_email = '';
        }

        $receiver_email = isset( $data[ 'receiver_email' ] ) ? sanitize_text_field( $data[ 'receiver_email' ] ) : '';
        
        $predefined_receiver = false;

        if ( isset( $data[ 'predefined_email_receiver' ] ) && $data[ 'predefined_email_receiver' ] ) {
            $receiver_email = $data[ 'predefined_email_receiver' ] ;
            $predefined_receiver = true;
        }

        $receiver_email = filter_var( $receiver_email, FILTER_SANITIZE_EMAIL );

        if ( filter_var( $receiver_email, FILTER_VALIDATE_EMAIL ) === false ) {
            $receiver_email = '';
        }

        $product = isset( $data[ 'product' ] ) ? $data[ 'product' ] : '';
        $product_data = [];

        if ( $product ) {
            list( $product_type, $product_name ) = explode( '::', $product );
            if ( 'theme' === $product_type ) {
                $installed_themes = wp_get_themes([
                                        'errors' => null
                                    ]);
                if ( count( $installed_themes ) && isset( $installed_themes[ $product_name ] )) {
                    $product_exists = true;
                }
            } else {
                $installed_plugins = get_plugins();
                if ( count( $installed_plugins ) && isset( $installed_plugins[ $product_name ] ) ) {
                    $product_exists = true;
                }
            }

            if ( $product_exists ) {
                $product_data[ 'name' ] = $product_name;
                $product_data[ 'type' ] = $product_type;
            }

        }

        $send_php_data = isset( $data[ 'php_data' ] ) ? (bool)$data[ 'php_data' ] : false;
        
        $send_theme_data = isset( $data[ 'theme_data' ] ) ? (bool)$data[ 'theme_data' ] : false;

        $theme_data = [];

        if ( $send_theme_data ) {
            $total_theme_data = wp_get_theme();
            $theme_data = [
                'name' => $total_theme_data->get( 'Name' ),
                'uri' => $total_theme_data->get( 'ThemeURI' ),
                'author' => $total_theme_data->get( 'Author' ),
                'author_uri' => $total_theme_data->get( 'AuthorURI' ),
                'version' => $total_theme_data->get( 'Version' ),
                'template' => $total_theme_data->get( 'Template' ),
            ];
        }

        $plugins_data = isset( $data[ 'plugins_data' ] ) ? array_keys( array_filter( $data[ 'plugins_data' ] ) ) : [];

        global $post;

        update_post_meta( $post->ID, '_' . WELLCRAFTED_SUPPORT, [
            'sender_name' => $sender_name,
            'sender_email' => $sender_email,
            'receiver_email' => $receiver_email,
            'predefined_receiver' => $predefined_receiver,
            'product' => $product_data,
            'send_php_data' => $send_php_data,
            'theme_data' => $theme_data,
            'plugins_data' => $plugins_data
        ] );

        if ( isset( $data[ 'send' ] ) ) {
            $errors = Wellcrafted_Support_Request::send( $post->ID );

            if ( $errors ) {
                add_filter( 'redirect_post_location', function( $location ) use( $errors ) {
                    return add_query_arg( [ $errors ], $location );
                }, 99 );
            } else {
                add_filter( 'redirect_post_location', function( $location ) use( $errors ) {
                    return add_query_arg( [ WELLCRAFTED_SUPPORT . '_request_sent' => true ], $location );
                }, 99 );
            }
        }

    }

    protected function current_post_updated_messages( $messages ) {
        $messages[1] = __( 'Request saved', WELLCRAFTED_SUPPORT );
        return $messages;
    }

}

