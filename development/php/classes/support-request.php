<?php

class Wellcrafted_Support_Request {

    public static function send( $request_id ) {

        $errors = [];
        $sent = false;

        $request = get_post( $request_id );

        $data = get_post_meta( $request->ID, '_' . WELLCRAFTED_SUPPORT, 1 );

        $uid = md5( uniqid( time() ) );

        $sender_email = $data[ 'sender_email' ];

        if ( ! $sender_email ) {
            $errors[ WELLCRAFTED_SUPPORT . '_error' ][] = WELLCRAFTED_SUPPORT . '_request_fill_sender';
        }
        
        $receiver_email = $data[ 'receiver_email' ];

        if ( ! $receiver_email ) {
            $errors[ WELLCRAFTED_SUPPORT . '_error' ][] = WELLCRAFTED_SUPPORT . '_request_fill_receiver';
        }

        if ( empty( $errors ) ) {
            $headers = [
                "From: $sender_email <$sender_email>\r\n",
                "Reply-To: $sender_email\r\n"
            ];

            $message = '<h1>' . get_the_title( $request->ID ) . "</h1>\r\n\r\n";
            $message .= do_shortcode( $request->post_content ) . "\r\n\r\n";
            
            if ( $data[ 'theme_data' ] ) {
                $message .= '<h2>' . __( 'Theme details', WELLCRAFTED_SUPPORT ) . ": </h2>\r\n";
                $message .= '<ul>';
                $message .= '<li>' . __( 'Name', WELLCRAFTED_SUPPORT ) . ': ' . $data[ 'theme_data' ][ 'name' ] . '</li>';
                $message .= '<li>' . __( 'URI', WELLCRAFTED_SUPPORT ) . ': ' . $data[ 'theme_data' ][ 'uri' ] . '</li>';
                $message .= '<li>' . __( 'Author', WELLCRAFTED_SUPPORT ) . ': ' . $data[ 'theme_data' ][ 'author' ] . '</li>';
                $message .= '<li>' . __( 'Author URI', WELLCRAFTED_SUPPORT ) . ': <a href="' . $data[ 'theme_data' ][ 'author_uri' ] . '" target="_blank">' . $data[ 'theme_data' ][ 'author_uri' ] . '</a></li>';
                $message .= '<li>' . __( 'Version', WELLCRAFTED_SUPPORT ) . ': ' . $data[ 'theme_data' ][ 'version' ] . '</li>';
                $message .= '<li>' . __( 'Template', WELLCRAFTED_SUPPORT ) . ': ' . $data[ 'theme_data' ][ 'template' ] . '</li>';
                $message .= '</ul>';
            }

            if ( $data[ 'plugins_data' ] ) {
                $installed_plugins = get_plugins();

                $message .= '<h2>' . __( 'Installed plugins', WELLCRAFTED_SUPPORT ) . ": </h2>\r\n";
                $message .= '<ul>';

                foreach ( $data[ 'plugins_data' ] as $plugin ) {
                    if ( ! isset( $installed_plugins[ $plugin ] ) ) {
                        $message .= '<li>' . $plugin . '</li>';
                        continue;
                    }

                    $installed_plugin = $installed_plugins[ $plugin ];
                    $is_active = is_plugin_active( $plugin );
                    if ( $is_active ) {
                        $message .= '<li><b>' . $installed_plugin[ 'Name' ] . '</b>';
                    } else {
                        $message .= '<li>' . $installed_plugin[ 'Name' ];
                    }
                    $message .= '<ul>';
                    $message .= '<li>' . __( 'Active', WELLCRAFTED_SUPPORT ) . ': ' . ( $is_active ? __( 'Yes', WELLCRAFTED_SUPPORT ) : __( 'No', WELLCRAFTED_SUPPORT ) ) . '</li>';
                    $message .= '<li>' . __( 'Plugin URI', WELLCRAFTED_SUPPORT ) . ': ' . $installed_plugin[ 'PluginURI' ] . '</li>';
                    $message .= '<li>' . __( 'Version', WELLCRAFTED_SUPPORT ) . ': ' . $installed_plugin[ 'Version' ] . '</li>';
                    $message .= '<li>' . __( 'Description', WELLCRAFTED_SUPPORT ) . ': ' . $installed_plugin[ 'Description' ] . '</li>';
                    $message .= '<li>' . __( 'Author', WELLCRAFTED_SUPPORT ) . ': ' . $installed_plugin[ 'Author' ] . '</li>';
                    $message .= '<li>' . __( 'Author URI', WELLCRAFTED_SUPPORT ) . ': <a href="' . $installed_plugin[ 'AuthorURI' ] . '" target="_blank">' . $installed_plugin[ 'AuthorURI' ] . '</a></li>';
                    $message .= '<li>' . __( 'Textdomain', WELLCRAFTED_SUPPORT ) . ': ' . $installed_plugin[ 'TextDomain' ] . '</li>';
                    $message .= '<li>' . __( 'Network', WELLCRAFTED_SUPPORT ) . ': ' . $installed_plugin[ 'Network' ] . '</li>';
                    $message .= '<li>' . __( 'Title', WELLCRAFTED_SUPPORT ) . ': ' . $installed_plugin[ 'Title' ] . '</li>';
                    $message .= '<li>' . __( 'Author Name', WELLCRAFTED_SUPPORT ) . ': ' . $installed_plugin[ 'AuthorName' ] . '</li>';
                    $message .= '</ul>';
                    $message .= '</li>';
                }
                $message .= '</ul>';
            }

            if ( $data[ 'send_php_data' ] ) {
                ob_start();
                phpinfo();
                $message .= ob_get_clean();
            }

            add_filter( 'wp_mail_content_type', 'wellcrafted_set_html_content_type' );

            $sent =  wp_mail( 
                $receiver_email, 
                sprintf( __( 'Support request: %s', WELLCRAFTED_SUPPORT ), get_the_title( $request->ID ) ), 
                $message,
                $headers
            );

            remove_filter( 'wp_mail_content_type', 'wellcrafted_set_html_content_type' );

            if ( $sent ) {
                add_post_meta( $request->ID, '_' . WELLCRAFTED_SUPPORT . '_sent_requests_data', [ 
                    'email' => $receiver_email,
                    'time' => time()
                ] );
            } else {
                $errors[ WELLCRAFTED_SUPPORT . '_error' ][] = WELLCRAFTED_SUPPORT . '_request_wasnt_sent';
            }
        } 

        return $errors;
    }

}
