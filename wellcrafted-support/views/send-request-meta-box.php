<?php 
/**
 * @todo  PHPDoc
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} 
?>
<?php if ( $saved ) { ?>
    <div class="wellcrafted_support_sendings_dates">
        <?php if ( $sent_requests_data ) { ?>
            <?php $sent_requests_data = array_reverse( $sent_requests_data ) ?>
            <?php $sendings_count = count( $sent_requests_data ) ?>
            <h4><?php _e( 'Previous sendings', WELLCRAFTED_SUPPORT ) ?></h4>
            <ol>
                <?php foreach ( $sent_requests_data as $index => $sent_request_data ) { ?>
                    <li value="<?php echo $sendings_count - $index ?>"><?php echo date( get_option( 'date_format' ) . ' G:i:s', $sent_request_data[ 'time' ] ) ?> <br> <?php echo $sent_request_data[ 'email' ]  ?></li>
                <?php } ?>
            </ol>
        <?php } else { ?>
            <p><?php _e( 'There were no sendings yet', WELLCRAFTED_SUPPORT ) ?></p>
        <?php } ?>
    </div>
    <div class="wellcrafted-send-actions">
        <input name="<?php echo WELLCRAFTED_SUPPORT ?>[send]" 
            class="button button-secondary button-large" 
            id="wellcrafted-support-send" 
            value="<?php echo __( 'Send', WELLCRAFTED_SUPPORT )?>" 
            type="submit">
    </div>
<?php } else { ?>
    <div class="wellcrafted_support_save_first_notice">
        <?php _e( 'You should save first to send.', WELLCRAFTED_SUPPORT ) ?>
    </div>
<?php } ?>