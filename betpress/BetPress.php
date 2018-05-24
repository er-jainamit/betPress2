<?php

/*
* Plugin Name: BetPress Lite
* Plugin URI: http://www.web-able.com/betpress/
* Description: A game where users predict sports games by placing betting slips.
* Author: WebAble
* Author URI: http://www.web-able.com
* Version: 1.0.1 Lite
*/


//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}


global $betpress_version, $betpress_db_version;

$betpress_version = '1.0.1 Lite';
$betpress_db_version = '1.0';


//add some constants
define('BETPRESS_DIR_PATH', plugin_dir_path(__FILE__));
define('BETPRESS_MAIN_FILE_DIR', __FILE__);
define('BETPRESS_IMAGE_FOLDER', plugin_dir_url(__FILE__) . 'includes' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR);
define('BETPRESS_VIEWS_DIR', BETPRESS_DIR_PATH . 'views' . DIRECTORY_SEPARATOR);
define('BETPRESS_TIME', 'd-m-Y H:i O');
define('BETPRESS_TIME_NO_ZONE', 'd-m-Y H:i');
define('BETPRESS_TIME_HUMAN_READABLE', 'l jS \of F Y h:i:s A');
define('BETPRESS_DECIMAL', 'decimal');
define('BETPRESS_FRACTION', 'fraction');
define('BETPRESS_AMERICAN', 'american');
define('BETPRESS_SPORTS_TO_ADD_DURING_ACTIVATION', 2);
define('BETPRESS_EVENTS_TO_ADD_DURING_ACTIVATION', 2);
define('BETPRESS_BET_EVENTS_TO_ADD_DURING_ACTIVATION', 2);
define('BETPRESS_BET_EVENTS_CATS_TO_ADD_DURING_ACTIVATION', 2);
define('BETPRESS_STATUS_UNSUBMITTED', 'unsubmitted');
define('BETPRESS_STATUS_AWAITING', 'awaiting');
define('BETPRESS_STATUS_WINNING', 'winning');
define('BETPRESS_STATUS_LOSING', 'losing');
define('BETPRESS_STATUS_CANCELED', 'canceled');
define('BETPRESS_STATUS_TIMED_OUT', 'timed_out');
define('BETPRESS_STATUS_ACTIVE', 'active');
define('BETPRESS_STATUS_PAST', 'past');
define('BETPRESS_STATUS_FAIL', 'fail');
define('BETPRESS_STATUS_PAID', 'paid');
define('BETPRESS_VALUE_YES', 'yes');
define('BETPRESS_VALUE_ON', 'on');
define('BETPRESS_VALUE_ALL', 'all');

define('BETPRESS_XML_URL', 'http://web-able.com/betpress.xml');


//include custom functions and db queries
if (file_exists(BETPRESS_DIR_PATH . 'functions.php')) {
    
    require_once 'functions.php';
}


//include wp ajax library
function betpress_add_ajax_library() {
    
    if (file_exists(BETPRESS_DIR_PATH . 'includes' . DIRECTORY_SEPARATOR . 'ajaxurl.php')) {
    
        require_once 'includes' . DIRECTORY_SEPARATOR . 'ajaxurl.php';
    } 
}
add_action('wp_head', 'betpress_add_ajax_library');


//load js & css
function betpress_register_scripts() {
    
    wp_register_script('js_front', plugins_url('/includes/js/front.js', __FILE__), array('jquery', 'wp-ajax-response'), false, true);
    wp_register_script('js_timepicker', plugins_url('/includes/js/timepicker.js', __FILE__), array('jquery'), false, true);
    wp_register_style('css_style', plugins_url('/includes/css/style.css', __FILE__));
}
add_action('init', 'betpress_register_scripts');


//use js & css
function betpress_use_scripts() {
    
    wp_enqueue_style('css_style', plugins_url('/includes/css/style.css', __FILE__));
    wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
    
    if (is_admin()) {
        
        wp_enqueue_style('wp-color-picker');
        
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_script('js_timepicker', plugins_url('/includes/js/timepicker.js', __FILE__), array('jquery'), false, true);
        wp_enqueue_script('js_admin', plugins_url('/includes/js/admin.js', __FILE__), array('jquery', 'js_timepicker', 'wp-color-picker'), false, true);
        
        wp_localize_script(
                'js_admin',
                'i18n_admin',
                array(
                    'sport_delete_confirm_message' => __('You are about to delete the sport and all the sport associated data. Are you sure?', 'BetPress'),
                    'event_delete_confirm_message' => __('You are about to delete the event and all the event associated data. Are you sure?', 'BetPress'),
                    'bet_event_delete_confirm_message' => __('You are about to delete the bet event and all the bet event associated data. Are you sure?', 'BetPress'),
                    'cat_delete_confirm_message' => __('You are about to delete the category and all the category associated data. Are you sure?', 'BetPress'),
                    'bet_option_delete_confirm_message' => __('You are about to delete the bet option and all the bet option associated data. Are you sure?', 'BetPress'),
                )
        );
        
    } else {
        
        wp_enqueue_script('js_front', plugins_url('/includes/js/front.js', __FILE__), array('jquery'), false, true);     
        
        wp_localize_script(
                'js_front',
                'i18n_front',
                array(
                    'show' => __('Show', 'BetPress'),
                    'hide' => __('Hide', 'BetPress'),
                    'toggle_symbol_minus' => __('-', 'BetPress'),
                    'toggle_symbol_plus' => __('+', 'BetPress'),
                    'loading' => __('Loading...', 'BetPress'),
                )
        );
    }
}
add_action('wp_enqueue_scripts', 'betpress_use_scripts');
add_action('admin_enqueue_scripts', 'betpress_use_scripts');


//load translations
function betpress_load_translations() {
    
    load_plugin_textdomain('BetPress', FALSE, dirname(plugin_basename(__FILE__)) . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR);
}
add_action('plugins_loaded', 'betpress_load_translations');


function betpress_display_odd($decimal_odd_string) {
    
    $decimal_odd = (float) $decimal_odd_string;
    
    return $decimal_odd;
}
add_filter('betpress_odd', 'betpress_display_odd');


//register the settings the wp way
function betpress_register_settings() {

    register_setting('bp_settings_group', 'bp_starting_points', 'betpress_sanitize_positive_number');
    register_setting('bp_settings_group', 'bp_close_bets', 'betpress_sanitize_positive_number');
    register_setting('bp_settings_group', 'bp_min_stake', 'betpress_sanitize_positive_number');
    register_setting('bp_settings_group', 'bp_max_stake', 'betpress_sanitize_positive_number');
    register_setting('bp_settings_group', 'bp_sport_title_bg_color', 'betpress_sanitize_color');
    register_setting('bp_settings_group', 'bp_sport_title_text_color', 'betpress_sanitize_color');
    register_setting('bp_settings_group', 'bp_sport_container_bg_color', 'betpress_sanitize_color');
    register_setting('bp_settings_group', 'bp_event_title_bg_color', 'betpress_sanitize_color');
    register_setting('bp_settings_group', 'bp_event_title_text_color', 'betpress_sanitize_color');
    register_setting('bp_settings_group', 'bp_event_container_bg_color', 'betpress_sanitize_color');
    register_setting('bp_settings_group', 'bp_bet_event_title_bg_color', 'betpress_sanitize_color');
    register_setting('bp_settings_group', 'bp_bet_event_title_text_color', 'betpress_sanitize_color');
    register_setting('bp_settings_group', 'bp_cat_title_bg_color', 'betpress_sanitize_color');
    register_setting('bp_settings_group', 'bp_cat_title_text_color', 'betpress_sanitize_color');
    register_setting('bp_settings_group', 'bp_cat_container_bg_color', 'betpress_sanitize_color');
    register_setting('bp_settings_group', 'bp_button_bg_color', 'betpress_sanitize_color');
    register_setting('bp_settings_group', 'bp_button_text_color', 'betpress_sanitize_color');
    register_setting('bp_settings_group', 'bp_featured_heading_bg_color', 'betpress_sanitize_color');
    register_setting('bp_settings_group', 'bp_featured_heading_text_color', 'betpress_sanitize_color');
    register_setting('bp_settings_group', 'bp_featured_name_bg_color', 'betpress_sanitize_color');
    register_setting('bp_settings_group', 'bp_featured_name_text_color', 'betpress_sanitize_color');
    register_setting('bp_settings_group', 'bp_featured_button_bg_color', 'betpress_sanitize_color');
    register_setting('bp_settings_group', 'bp_featured_button_text_color', 'betpress_sanitize_color');
    register_setting('bp_settings_group', 'bp_lb_table_text_color', 'betpress_sanitize_color');
    register_setting('bp_settings_group', 'bp_lb_heading_bg_color', 'betpress_sanitize_color');
    register_setting('bp_settings_group', 'bp_lb_odd_bg_color', 'betpress_sanitize_color');
    register_setting('bp_settings_group', 'bp_lb_even_bg_color', 'betpress_sanitize_color');
    register_setting('bp_settings_group', 'bp_slip_heading_bg_color', 'betpress_sanitize_color');
    register_setting('bp_settings_group', 'bp_slip_heading_text_color', 'betpress_sanitize_color');
    register_setting('bp_settings_group', 'bp_slip_row_bg_color', 'betpress_sanitize_color');
    register_setting('bp_settings_group', 'bp_slip_row_text_color', 'betpress_sanitize_color');
    register_setting('bp_settings_group', 'bp_slip_subrow_bg_color', 'betpress_sanitize_color');
    register_setting('bp_settings_group', 'bp_slip_subrow_text_color', 'betpress_sanitize_color');
}
add_action('admin_init', 'betpress_register_settings');


//register admin menu
function betpress_register_admin_menu_page() {
    
    add_menu_page(
            __('BetPress settings', 'BetPress'),    //page title
            __('BetPress', 'BetPress'),             //menu title
            'manage_options',                       //capability
            'betpress-settings',                    //menu slug
            'betpress_settings_controller'          //callback
    );

    add_submenu_page(
            'betpress-settings',                    //parent slug
            __('Bettings', 'BetPress'),             //page title
            __('Bettings', 'BetPress'),             //menu title
            'manage_options',                       //capability
            'betpress-sports-and-events',           //menu slug
            'betpress_bettings_controller'          //callback
    );
    
    add_submenu_page(
            'betpress-settings',
            __('Leaderboards', 'BetPress'),
            __('Leaderboards', 'BetPress'),
            'manage_options',
            'bp-leaderboards',
            'betpress_leaderboards_controller'
    );
    
    add_submenu_page(
            'betpress-settings',
            __('PayPal log', 'BetPress'),
            __('PayPal log', 'BetPress'),
            'manage_options',
            'bp-paypal',
            'betpress_paypal_controller'
    );
    
    add_submenu_page(
            'betpress-settings',
            __('Auto insert data', 'BetPress'),
            __('Auto insert data', 'BetPress'),
            'manage_options',
            'bp-auto-insert',
            'betpress_auto_insert_controller'
    );

}
add_action('admin_menu', 'betpress_register_admin_menu_page');


function betpress_modify_admin_users_table($column) {
    
    $column['betpress_points'] = __('BetPress Points', 'BetPress');
    $column['betpress_buyed_points'] = __('BetPress Bought Points', 'BetPress');
    
    return $column;
}
add_filter('manage_users_columns', 'betpress_modify_admin_users_table');


function betpress_modify_admin_users_table_data($val, $column_name, $user_ID) {
    
    switch ($column_name) {
        
        case 'betpress_points' :
            $user_points_db = get_user_meta($user_ID, 'bp_points', true);
            $user_points = ('' === $user_points_db) ? get_option('bp_starting_points') : (float) $user_points_db;
            return $user_points;
            
        case 'betpress_buyed_points' :
            return ( (int) get_user_meta($user_ID, 'bp_points_buyed', true) );
            
        default:
            return;
    }
}
add_filter('manage_users_custom_column', 'betpress_modify_admin_users_table_data', 10, 3);


function betpress_admin_user_custom_profile($user) {
    
    $user_points_db = esc_attr(get_user_meta($user->ID, 'bp_points', true));
    $user_points_buyed_db = esc_attr(get_user_meta($user->ID, 'bp_points_buyed', true));

    $pass['user_points'] = ('' === $user_points_db) ? get_option('bp_starting_points') : (float) $user_points_db;
    $pass['user_buyed_points'] = (int) $user_points_buyed_db;
    betpress_get_view('user-edit-extra-fields', 'admin', $pass);
}
add_action('edit_user_profile', 'betpress_admin_user_custom_profile');
add_action('show_user_profile', 'betpress_admin_user_custom_profile');


function betpress_admin_user_custom_profile_save($user_ID) {
	
	if ( ! current_user_can('manage_options') ) {
            return false;
        }
	
	update_user_meta($user_ID, 'bp_points', betpress_sanitize($_POST['bp_points']));
	update_user_meta($user_ID, 'bp_points_buyed', betpress_sanitize($_POST['bp_points_buyed']));
}
add_action('edit_user_profile_update', 'betpress_admin_user_custom_profile_save');
add_action('personal_options_update', 'betpress_admin_user_custom_profile_save');

function betpress_add_dashboard_widgets() {
    
    if (current_user_can('manage_options')) {
        
        wp_add_dashboard_widget('betpress_dashboard', __('BetPress', 'BetPress'), 'betpress_render_admin_dashboard_widget');
    }
}
add_action('wp_dashboard_setup', 'betpress_add_dashboard_widgets' );

function betpress_add_update_link($links) {
    
   $links [] = sprintf(esc_attr__('%s Upgrade to the full version %s', 'BetPress'), '<a href="http://web-able.com/betpress/" target="_blank">', '</a>');
   
   return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'betpress_add_update_link');



//include folders
betpress_require('controllers');
betpress_require('widgets');