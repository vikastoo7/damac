<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

//create table in database to store attachment data for gravity form
function wot_attachment_form_create_tables(){
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    $create_table = "CREATE TABLE IF NOT EXISTS ".WOTADFORM_DATA_TABLE." (
                id int unsigned NOT NULL auto_increment PRIMARY KEY,
                gf_id bigint(20) NOT NULL,
                gf_attachment longtext NOT NULL,              
                gf_attach_option bigint(20) NOT NULL             
            ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $create_table );
}

//delete table and data from database
function wot_attachment_form_drop_tables(){
    global $wpdb;

    $wpdb->query( 'DROP TABLE IF EXISTS '.WOTADFORM_DATA_TABLE.' ' );
}

//filter to add tab in single gravity form setting
add_filter( 'gform_form_settings_menu', 'wot_attachment_form_option' );
function wot_attachment_form_option( $menu_items ) {

    $menu_items[] = array(
        'name' => 'wot_attachment_download_form',
        'label' => __( 'Attachment Download' )
    );

    return $menu_items;
}

// Action to show attachment upload options
add_action( 'gform_form_settings_page_wot_attachment_download_form', 'wot_attachment_form_option_page' );
function wot_attachment_form_option_page() {
    global $wpdb;
    GFFormSettings::page_header();
    $currentformid = intval(sanitize_text_field($_GET['id']));

    $select_query = "SELECT * FROM ".WOTADFORM_DATA_TABLE." WHERE gf_id = %d";
    $select_result = $wpdb->get_results( $wpdb->prepare( $select_query, array($currentformid ) ) );
    if ( ! did_action( 'wp_enqueue_media' ) ) {
        wp_enqueue_media();
    }
    wp_enqueue_script('wot-ad-form-admin-scripts',WOTADFORM_ADMIN_URL.'/js/wot-admin-scripts.js',array(),NULL,true);

    ?>

    <h3>
            <span>
                <i class="fa-solid fa-atom"></i> <?php _e( 'Form Submission Options', 'attachment-download-on-gravity-form-submission' ); ?>
            </span>
    </h3>
    <p> <?php _e( 'Upload Attachment here which will be available to user after form submission.', 'attachment-download-on-gravity-form-submission' ); ?></p>
    <?php
    if( !empty( $select_result ) ){
        $attachment_data = $select_result[0];
        ?>

        <?php

        ?>
        <div class="gform_panel gform_panel_form_settings">
            <form action="" method="POST">
                <input type="hidden" name="wot_attachment_form_id" value="<?php echo esc_attr($currentformid); ?>" />
                <table class="gforms_form_settings" cellspacing="0" cellpadding="0">
                    <tbody>
                    <tr valign="top">
                        <th scope="row"><label for="wot_attachment_name"><?php _e('Select File ','attachment-download-on-gravity-form-submission');?></label></th>
                        <td>
                            <?php
                            if( !empty($attachment_data->gf_attachment) && $woo_attachment_file = wp_get_attachment_url( $attachment_data->gf_attachment ) ) { ?>

                                <a href="<?php echo esc_url($woo_attachment_file)?>" class="wot_attachment_name"> <?php echo esc_attr(basename($woo_attachment_file));?></a>&nbsp;
                                <a href="javascript:void(0)" class="remove-attachment"><i class="dashicons-before dashicons-dismiss"></i></a>
                                <input type="hidden" name="wot_attachment_file_input" class="wot_attachment_file_input" value="<?php echo esc_attr($attachment_data->gf_attachment);?>">
                                <?php
                            }else
                            {
                                ?>

                                <a href="javascript:void(0)" class="wot_attachment_name" ><i class="dashicons-before dashicons-upload"></i> </a>
                                <a href="javascript:void(0)" class="remove-attachment" style="display:none"><i class="dashicons-before dashicons-dismiss"></i></a>
                                <input type="hidden" name="wot_attachment_file_input" class="wot_attachment_file_input" value="">
                            <?php }
                            ?>

                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="wot_attachment_name"><?php _e('Attachment Option','attachment-download-on-gravity-form-submission');?></label>
                        </th>
                        <td>
                            <label>
                                <input type="radio" name="wot_attachment_option" value="1"  <?php echo (isset($attachment_data->gf_attach_option) && $attachment_data->gf_attach_option == 1 ) ? "checked" : "";?>/><?php _e('Download attachment','attachment-download-on-gravity-form-submission');?>
                            </label>
                            <label>
                                <input type="radio" name="wot_attachment_option" value="0" <?php echo (isset($attachment_data->gf_attach_option) && $attachment_data->gf_attach_option == 0 ) ? "checked" : "";?> /><?php _e('Open attachment in new tab','attachment-download-on-gravity-form-submission');?>
                            </label>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><input type="submit" class="button-primary" name="wot_update_attachment" value="<?php _e('Save', 'attachment-download-on-gravity-form-submission' ); ?>" /></th>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>

        <?php
    }else{
        ?>

        <div class="gform_panel gform_panel_form_settings">
            <form action="" method="POST">
                <input type="hidden" name="wot_attachment_form_id" value="<?php echo esc_attr($currentformid); ?>" />
                <table class="gforms_form_settings" cellspacing="0" cellpadding="0">
                    <tbody>
                    <tr valign="top">
                        <th scope="row"><label for="wot_attachment_name"><?php _e('Select File ','attachment-download-on-gravity-form-submission');?></label></th>
                        <td>
                            <a href="javascript:void(0)" class="wot_attachment_name" ><i class="dashicons-before dashicons-upload"></i> </a>
                            <a href="javascript:void(0)" class="remove-attachment" style="display:none"><i class="dashicons-before dashicons-dismiss"></i></a>
                            <input type="hidden" name="wot_attachment_file_input" class="wot_attachment_file_input" value="">
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="wot_attachment_name"><?php _e('Attachment Option','attachment-download-on-gravity-form-submission');?></label>
                        </th>
                        <td>
                            <label>
                                <input type="radio" name="wot_attachment_option" value="1" checked/><?php _e('Download attachment','attachment-download-on-gravity-form-submission');?>
                            </label>
                            <label>
                                <input type="radio" name="wot_attachment_option" value="0" /><?php _e('Open attachment in new tab','attachment-download-on-gravity-form-submission');?>
                            </label>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><input type="submit" class="button-primary" name="wot_save_attachment" value="<?php _e('Save', 'attachment-download-on-gravity-form-submission' ); ?>" /></th>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </div>
        <?php
    }

    GFFormSettings::page_footer();
}

//Action to save and update attachment data
add_action( 'admin_init', 'wot_attachment_form_save_data' );
function wot_attachment_form_save_data(){
    if( isset( $_POST['wot_save_attachment'] ) && !empty( $_POST['wot_save_attachment'] ) ){

        global $wpdb;
        $form_id = !empty( $_POST['wot_attachment_form_id'] ) ? intval($_POST['wot_attachment_form_id']) : '';
        $attach_file_id = !empty( $_POST['wot_attachment_file_input'] ) ? (intval(sanitize_text_field($_POST['wot_attachment_file_input']))) : '';
        $wot_attachment_option = !empty( $_POST['wot_attachment_option'] ) ? (intval(sanitize_text_field($_POST['wot_attachment_option']))) : '';


        if( !empty( $attach_file_id ) && !empty( $form_id ) ){

            /*
             * Attachment Option 1 : Download , 0 : New Tab
            */
            $wpdb->insert(WOTADFORM_DATA_TABLE, array(
                'gf_id' => $form_id,
                'gf_attachment' => $attach_file_id,
                'gf_attach_option'=>(!empty($wot_attachment_option)) ? $wot_attachment_option : 0
            ));

        }

    } elseif( isset( $_POST['wot_update_attachment'] ) && !empty( $_POST['wot_update_attachment'] ) ){

        global $wpdb;

        $form_id = !empty( $_POST['wot_attachment_form_id'] ) ? intval($_POST['wot_attachment_form_id']) : '';
        $attach_file_id = !empty( $_POST['wot_attachment_file_input'] ) ? (intval(sanitize_text_field($_POST['wot_attachment_file_input']))) : '';
        $wot_attachment_option = !empty( $_POST['wot_attachment_option'] ) ? (intval(sanitize_text_field($_POST['wot_attachment_option']))) : '';

        $wpdb->update(WOTADFORM_DATA_TABLE, array(
            'gf_attachment' => $attach_file_id,
            'gf_attach_option'=>(!empty($wot_attachment_option)) ? $wot_attachment_option : 0
        ),
            array('gf_id' => $form_id )
        );
    }
}

