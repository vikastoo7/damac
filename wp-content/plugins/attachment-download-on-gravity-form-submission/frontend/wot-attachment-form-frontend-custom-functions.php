<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/*
 * Add Download attachment option after gravity form submission without ajax
 * */
add_filter("gform_confirmation", "wot_attachment_form_custom_confirmation", 10, 4);
function wot_attachment_form_custom_confirmation($confirmation, $form, $entry, $ajax){

    if( $ajax ) {
        return $confirmation;
    }

    global $wpdb;
    $select_query = "SELECT * FROM ".WOTADFORM_DATA_TABLE." WHERE gf_id = %d";
    $select_result = $wpdb->get_results( $wpdb->prepare( $select_query, array($form['id'] ) ) );
    if( !empty( $select_result ) ) {

        $attachment_data = $select_result[0];
        $attachment_file  = $attachment_data->gf_attachment;
        $gf_attach_option  = $attachment_data->gf_attach_option;

        if( !empty($attachment_file) ) {
            if($gf_attach_option == 0) {
                $redirect = esc_url(wp_get_attachment_url( $attachment_file ));
                if( is_array($confirmation) ) {
                    $confirmation_new = $confirmation;
                }
                else {
                    $confirmation_new = $confirmation;
                }
                    $confirmation_new .= "<script type=\"text/javascript\">var redirectWindow = window.open('$redirect'); </script>";
                    return $confirmation_new;


            }
            else if( $gf_attach_option == 1 ) {
                $redirect = esc_url(wp_get_attachment_url( $attachment_file ));
                $filename = esc_attr(basename($redirect));
                if( is_array($confirmation) ) {
                    return $confirmation;
                }
                else {
                    $confirmation_new = $confirmation;

                    $confirmation_new .= "<script type=\"text/javascript\">var link = document.createElement('a');
                                        link.href = '$redirect';
                                        link.download = '$filename';
                                        link.dispatchEvent(new MouseEvent('click')); </script>";
                    return $confirmation_new;

                }
            }
        }
    }
    return $confirmation;

}
/*
 * Add javascript to handle gravity form confirmation event
 * */
add_filter("init", "wot_attachment_form_custom_confirmation_script");
function wot_attachment_form_custom_confirmation_script()
{
    /*Add frontend script */
    wp_enqueue_script('wot-public-scripts', WOTADFORM_FRONT_URL . '/js/wot-public-scripts.js', array(), NULL, true);

    /* Localize frontend script for ajax request */
    wp_localize_script( 'wot-public-scripts', 'WOTADFORM_ADMIN', array('ajaxurl' => admin_url( 'admin-ajax.php' )));
}
add_action('wp_ajax_wot_ad_form_confirmation_redirection', 'wot_ad_form_confirmation_redirection');
add_action('wp_ajax_nopriv_wot_ad_form_confirmation_redirection', 'wot_ad_form_confirmation_redirection');

/*Ajax function to get download attachment details by form id */
function wot_ad_form_confirmation_redirection() {
    $formId = (isset($_REQUEST['formId'])) ? sanitize_text_field($_REQUEST['formId']) : '';
    if(!empty($formId)) {
        global $wpdb;
        $select_query = "SELECT * FROM ".WOTADFORM_DATA_TABLE." WHERE gf_id = %d";
        $select_result = $wpdb->get_results( $wpdb->prepare( $select_query, array($formId ) ) );
        if( !empty( $select_result ) ) {

            $attachment_data = $select_result[0];
            $attachment_file  = $attachment_data->gf_attachment;
            $gf_attach_option  = $attachment_data->gf_attach_option;

            if( !empty($attachment_file) ) {
                if($gf_attach_option == 0) {
                    $redirect = esc_url(wp_get_attachment_url( $attachment_file ));
                    echo wp_json_encode(array('url'=>$redirect,'ad_option'=>$gf_attach_option));
                }
                else if($gf_attach_option == 1) {
                    $redirect = esc_url(wp_get_attachment_url( $attachment_file ));
                    $filename = esc_attr(basename($redirect));
                    echo wp_json_encode(array('url'=>$redirect,'ad_option'=>$gf_attach_option,'filename'=>$filename));
                }
            }
        }
    }
    exit;
}