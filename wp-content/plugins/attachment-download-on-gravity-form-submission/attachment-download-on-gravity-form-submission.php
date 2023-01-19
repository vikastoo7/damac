<?php
/*
Plugin Name: Attachment Download On Gravity Form Submission
Plugin URI: https://wordpress.org/plugins/attachment-download-on-gravity-form-submission
Description: Admin can upload pdf or document attachment to each gravity form which will be downloaded after form submission
Version: 1.0.0
Author: WebOccult Technologies Pvt Ltd
Author URI: https://www.weboccult.com
Text Domain: attachment-download-on-gravity-form-submission
Domain Path: /languages
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if(!class_exists( 'RGForms' )){
    _e( 'Requires Gravity Forms to be installed.', 'attachment-download-on-gravity-form-submission' );
    exit;
}

if( !defined( 'WOTADFORM_DIR' ) ) {
    define('WOTADFORM_DIR', dirname( __FILE__ ) ); // plugin dir
}
if( !defined( 'WOTADFORM_URL' ) ) {
    define('WOTADFORM_URL', plugin_dir_url( __FILE__ ) ); // plugin url
}
if( !defined( 'WOTADFORM_ADMIN_DIR' ) ) {
    define('WOTADFORM_ADMIN_DIR', WOTADFORM_DIR . '/backend' ); // plugin admin dir
}
if( !defined( 'WOTADFORM_ADMIN_URL' ) ) {
    define('WOTADFORM_ADMIN_URL', WOTADFORM_URL . 'backend' ); // plugin admin url
}
if( !defined( 'WOTADFORM_DATA_TABLE' ) ) {
    global $wpdb;
    define( 'WOTADFORM_DATA_TABLE', $wpdb->prefix.'gfattachment_data' ); // plugin table name
}
if( !defined( 'WOTADFORM_FRONT_DIR' ) ) {
    define('WOTADFORM_FRONT_DIR', WOTADFORM_DIR . '/frontend' ); // plugin frontend dir
}
if( !defined( 'WOTADFORM_FRONT_URL' ) ) {
    define('WOTADFORM_FRONT_URL', WOTADFORM_URL . 'frontend' ); // plugin frontend url
}

//include custom function file for backend
include WOTADFORM_ADMIN_DIR . '/wot-attachment-form-backend-custom-functions.php';

//include custom function file for frontend
include WOTADFORM_FRONT_DIR . '/wot-attachment-form-frontend-custom-functions.php';

/**
 * Load Text Domain
 *
 * This gets the plugin ready for translation.
 */

function wot_attachment_form_load_textdomain() {
  load_plugin_textdomain( 'attachment-download-on-gravity-form-submission', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'init', 'wot_attachment_form_load_textdomain' );

/**
 * Activation Hook
 * Register plugin activation hook.
 */
register_activation_hook( __FILE__, 'wot_attachment_form_install' );

/**
 * Deactivation Hook
 * Register plugin deactivation hook.
 */
register_deactivation_hook( __FILE__, 'wot_attachment_form_deactivate' );

/**
 * Uninstall Hook
 * Register plugin deactivation hook.
 */
register_uninstall_hook ( __FILE__, 'wot_attachment_form_uninstall' );

/**
 * Plugin Setup (On Activation)
 * Does the initial setup,
 * set default values for the plugin options.
 */
function wot_attachment_form_install() {
    //create table to store attachment download and fields
    wot_attachment_form_create_tables();

    //IMP Call of Function
    //Need to call when custom post type is being used in plugin
    flush_rewrite_rules();
}

/**
 * Plugin Setup (On Deactivation)
 * Delete plugin options.
 */
function wot_attachment_form_deactivate() {
        
}

/**
 * Plugin Setup (On Uninstall)
 * Delete plugin options.
 */
function wot_attachment_form_uninstall() {
    //delete table and data from database
    wot_attachment_form_drop_tables();
}