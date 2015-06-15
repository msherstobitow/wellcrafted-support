<?php 
/**
 * @todo  PHPDoc
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} 
?>
<table class="form-table">
    <tbody>
        <tr>
            <th>
                <label for="<?php echo WELLCRAFTED_SUPPORT ?>_sender_name"><?php _e( 'Sender name', WELLCRAFTED_SUPPORT ) ?></label>
            </th>
            <td>
                <input type="text" 
                    name="<?php echo WELLCRAFTED_SUPPORT ?>[sender_name]"
                    id="<?php echo WELLCRAFTED_SUPPORT ?>_sender_name"
                    class="regular-text"
                    value="<?php echo $sender_name ?>">
            </td>
        </tr>
        <tr>
            <th>
                <label for="<?php echo WELLCRAFTED_SUPPORT ?>_sender_email"><?php _e( 'Sender email', WELLCRAFTED_SUPPORT ) ?></label>
            </th>
            <td>
                <input type="text" 
                    name="<?php echo WELLCRAFTED_SUPPORT ?>[sender_email]"
                    id="<?php echo WELLCRAFTED_SUPPORT ?>_sender_email"
                    class="regular-text"
                    value="<?php echo $sender_email ?>">
            </td>
        </tr>
        <tr>
            <th>
                <label for="<?php echo WELLCRAFTED_SUPPORT ?>_receiver_email"><?php _e( 'Receiver email', WELLCRAFTED_SUPPORT ) ?></label>
            </th>
            <td>
                <input type="text" 
                    name="<?php echo WELLCRAFTED_SUPPORT ?>[receiver_email]"
                    id="<?php echo WELLCRAFTED_SUPPORT ?>_receiver_email"
                    class="regular-text"
                    value="<?php echo $receiver_email ?>">
            </td>
        </tr>
        <?php if ( $developers_emails ) { ?>
            <tr>
                <th>
                    <label for="<?php echo WELLCRAFTED_SUPPORT ?>_predefined_email_receiver"><?php _e( 'You can choose a receiver from a list', WELLCRAFTED_SUPPORT ) ?></label>
                </th>
                <td>
                    <select name="<?php echo WELLCRAFTED_SUPPORT ?>[predefined_email_receiver]" 
                        class="wellcrafted_input_change_trigger"
                        data-target="#<?php echo WELLCRAFTED_SUPPORT ?>_receiver_email"
                        data-change-on-empty="false">
                        <option value=""><?php _e( 'Select email', WELLCRAFTED_SUPPORT ) ?></option>
                        <?php foreach ( $developers_emails as $title => $email ) {?>
                            <option value="<?php echo $email ?>" <?php selected( $receiver_email, $email ) ?>><?php echo $title ? $title : $email ?></option>
                        <?php } ?>
                    </select>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <th>
                <?php _e( 'Product', WELLCRAFTED_SUPPORT ) ?>
            </th>
            <td>
                <select  name="<?php echo WELLCRAFTED_SUPPORT ?>[product]">
                    <?php if ( $installed_themes || $installed_plugins ) { ?>
                        <?php if ( $installed_themes ) { ?>
                            <?php foreach( $installed_themes as $theme_name => $theme ) { ?>
                                <?php $is_theme_active = $theme_name === $active_theme_name ?>
                                <option value="theme::<?php echo $theme_name ?>"
                                    <?php echo selected( $is_theme_active ) ?>
                                    <?php echo $is_theme_active ? 'class="active"' : '' ?>>
                                    <?php if ( $is_theme_active ) { ?> 
                                        <b><?php echo $theme_name ?></b>
                                    <?php } else { ?>
                                        <?php echo $theme_name ?>
                                    <?php } ?>
                                </option>
                            <?php } ?>
                        <?php } ?>

                        <?php if ( $installed_plugins ) { ?>
                            <?php foreach( $installed_plugins as $plugin => $params ) { ?>
                                <?php $is_plugin_active = is_plugin_active( $plugin ) ?>
                                <option value="plugin::<?php echo $plugin ?>"
                                    <?php echo $is_plugin_active ? 'class="active"' : '' ?>>
                                    <?php echo $params[ 'Name' ] ?>
                                </option>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <th>
                <?php _e( 'Send current theme data', WELLCRAFTED_SUPPORT ) ?>
            </th>
            <td>
                <label>
                    <input type="hidden"
                        name="<?php echo WELLCRAFTED_SUPPORT ?>[theme_data]"
                        value="0">
                    <input type="checkbox" 
                        name="<?php echo WELLCRAFTED_SUPPORT ?>[theme_data]"
                        id="<?php echo WELLCRAFTED_SUPPORT ?>_theme_data"
                        <?php checked( (bool)wellcrafted_array_value( $data, 'theme_data' ), true ) ?>>
                    <?php _e( 'Yes', WELLCRAFTED_SUPPORT ) ?>
                </label>
            </td>
        </tr>
        <?php if ( $installed_plugins ) { ?>
            <tr>
                <th>
                    <?php _e( 'Send plugins data', WELLCRAFTED_SUPPORT ) ?>
                </th>
                <td class="wellcrafted_support_request_options_plugins_list">
                    <label for="<?php echo WELLCRAFTED_SUPPORT ?>_plugins_data_check_all">
                        <input type="checkbox" 
                            id="<?php echo WELLCRAFTED_SUPPORT ?>_plugins_data_check_all"
                            class="wellcrafted_checkboxes_group_toggler"
                            data-target=".<?php echo WELLCRAFTED_SUPPORT ?>_plugins_data_checkbox"> 
                            <?php _e( 'Select/deselect all', WELLCRAFTED_SUPPORT ) ?>
                    </label>
                    <br>
                     <?php foreach( $installed_plugins as $plugin => $params ) { ?>
                        <?php $is_plugin_active = is_plugin_active( $plugin ) ?>
                        <?php $is_plugin_checked = ( ! empty( $chosen_plugins ) && in_array( $plugin, $chosen_plugins ) ) || ( empty( $chosen_plugins ) && $is_plugin_active )  ?>
                        <label<?php echo ! $is_plugin_active ? '' : ' class="active" title="' . __( 'Active', WELLCRAFTED_SUPPORT ) . '"' ?>>
                            <input type="hidden"
                                name="<?php echo WELLCRAFTED_SUPPORT ?>[plugins_data][<?php echo $plugin ?>]"
                                value="0">
                            <input type="checkbox" 
                                name="<?php echo WELLCRAFTED_SUPPORT ?>[plugins_data][<?php echo $plugin ?>]"
                                id="<?php echo WELLCRAFTED_SUPPORT ?>_plugins_data"
                                class="<?php echo WELLCRAFTED_SUPPORT ?>_plugins_data_checkbox"
                                value="1"
                                <?php checked( $is_plugin_checked ) ?>> 
                                <span><?php echo $params[ 'Name' ] ?></span>
                        </label>
                        <br>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <th>
                <?php _e( 'Send PHP data', WELLCRAFTED_SUPPORT ) ?>
            </th>
            <td>
                <input type="hidden"
                    name="<?php echo WELLCRAFTED_SUPPORT ?>[php_data]"
                    value="0"?>
                <?php if ( wellcrafted_is_function_disabled( 'phpinfo' ) ) { ?>
                    <?php _e( 'Unfortunatelty, this option is not available on your hosting', WELLCRAFTED_SUPPORT ) ?>
                <?php } else { ?>
                    <label>
                        <input type="checkbox" 
                            name="<?php echo WELLCRAFTED_SUPPORT ?>[php_data]"
                            id="<?php echo WELLCRAFTED_SUPPORT ?>_php_data"
                            <?php checked( wellcrafted_array_value( $data, 'send_php_data' ), true ) ?>>
                        <?php _e( 'Yes', WELLCRAFTED_SUPPORT ) ?>
                    </label>
                    <div class="wellcrafted-form-title-note"><i><?php _e( 'Be careful, it can be not safe!', WELLCRAFTED_SUPPORT ) ?></i></div>
                <?php } ?>
            </td>
        </tr>
    </tbody>
</table>