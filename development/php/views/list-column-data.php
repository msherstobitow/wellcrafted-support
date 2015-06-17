<?php 
/**
 * Support request column markup.
 * 
 * @package Wellcrafted\Support
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}

?>
<b><?php _e( 'Sent date:', WELLCRAFTED_SUPPORT ) ?></b> 
<?php if ( isset( $request_data[ 'time' ] ) ) { 
    echo date( get_option( 'date_format' ) . ' G:i:s', $request_data[ 'time' ] );
} else {
    _e( 'Never', WELLCRAFTED_SUPPORT );
} ?>
<br>
<b><?php _e( 'Sender:', WELLCRAFTED_SUPPORT ) ?></b> 
<?php 
    $sender_name = wellcrafted_array_value( $request_options, 'sender_name' );
    echo $sender_name;
    
    $sender_email = wellcrafted_array_value( $request_options, 'sender_email' );
    if ( $sender_email ) {
        echo ( $sender_name ? ', ' : ''), $sender_email;
    }

    if ( ! $sender_name && ! $sender_email ) {
        _e( 'none', WELLCRAFTED_SUPPORT );
    }
?>
<br>
<b><?php _e( 'Receiver:', WELLCRAFTED_SUPPORT ) ?></b> 
<?php echo wellcrafted_array_value( $request_options, 'receiver_email', __( 'none', WELLCRAFTED_SUPPORT ) ) ?>