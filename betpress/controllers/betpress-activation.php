<?php

//set default settings when the plugin is activated (will not overwrite)
function betpress_default_settings() {
    
    $pp_success_msg = 
          'Thank you for your payment, the points are added into your account.'
          . ' Your transaction has been completed, and a receipt for your'
          . ' purchase has been emailed to you. You may log into your account'
          . ' at www.paypal.com to view details of this transaction.';
    
    $pp_error_msg = 
          'Error! Please contact the administrators and don\'t forget to'
          . ' tell them the exact time you saw this message.';

    add_option('bp_starting_points', 1000);
    add_option('bp_close_bets', 300);
    add_option('bp_min_stake', 1);
    add_option('bp_max_stake', 100);
    add_option('bp_default_odd_type', BETPRESS_DECIMAL);
    add_option('bp_one_win_per_cat', BETPRESS_VALUE_YES);
    add_option('bp_only_int_stakes', BETPRESS_VALUE_YES);
    add_option('bp_paypal_mail', get_option('admin_email'));
    add_option('bp_max_points_to_buy', 1000);
    add_option('bp_max_allowed_points', 100);
    add_option('bp_paypal_url_fail', get_option('home'));
    add_option('bp_paypal_token', '');
    add_option('bp_paypal_sandbox', 'no');
    add_option('bp_paypal_success_message', $pp_success_msg);
    add_option('bp_paypal_error_message', $pp_error_msg);
    add_option('bp_sport_title_bg_color', '#0f5959');
    add_option('bp_sport_title_text_color', '#efefef');
    add_option('bp_sport_container_bg_color', '#e8e8e8');
    add_option('bp_event_title_bg_color', '#17a697');
    add_option('bp_event_title_text_color', '#efefef');
    add_option('bp_event_container_bg_color', '#d8d8d8');
    add_option('bp_bet_event_title_bg_color', '#638ca6');
    add_option('bp_bet_event_title_text_color', '#efefef');
    add_option('bp_cat_title_bg_color', '#8fd4d9');
    add_option('bp_cat_title_text_color', '#424242');
    add_option('bp_cat_container_bg_color', '#e5e5e5');
    add_option('bp_button_bg_color', '#d93240');
    add_option('bp_button_text_color', '#eaeaea');
    add_option('bp_featured_heading_bg_color', '#d93240');
    add_option('bp_featured_heading_text_color', '#efefef');
    add_option('bp_featured_name_bg_color', '#17a697');
    add_option('bp_featured_name_text_color', '#efefef');
    add_option('bp_featured_button_bg_color', '#0f5959');
    add_option('bp_featured_button_text_color', '#f4f4f4');
    add_option('bp_lb_table_text_color', '#333333');
    add_option('bp_lb_heading_bg_color', '#17a697');
    add_option('bp_lb_odd_bg_color', '#e2f8ff');
    add_option('bp_lb_even_bg_color', '#d8e5ff');
    add_option('bp_slip_heading_bg_color', '#17a697');
    add_option('bp_slip_heading_text_color', '#222222');
    add_option('bp_slip_row_bg_color', '#8fd4d9');
    add_option('bp_slip_row_text_color', '#333333');
    add_option('bp_slip_subrow_bg_color', '#b6d7d8');
    add_option('bp_slip_subrow_text_color', '#333333');
    
    //in this array we save already used txn ids
    add_option('bp_paypal_txn_ids', array());
  
    //wpml
    betpress_register_string_for_translation('pp-success', $pp_success_msg);
    betpress_register_string_for_translation('pp-error', $pp_error_msg);
    betpress_register_string_for_translation('status-' . BETPRESS_STATUS_UNSUBMITTED, BETPRESS_STATUS_UNSUBMITTED);
    betpress_register_string_for_translation('status-' . BETPRESS_STATUS_AWAITING, BETPRESS_STATUS_AWAITING);
    betpress_register_string_for_translation('status-' . BETPRESS_STATUS_WINNING, BETPRESS_STATUS_WINNING);
    betpress_register_string_for_translation('status-' . BETPRESS_STATUS_LOSING, BETPRESS_STATUS_LOSING);
    betpress_register_string_for_translation('status-' . BETPRESS_STATUS_CANCELED, BETPRESS_STATUS_CANCELED);
    betpress_register_string_for_translation('status-' . BETPRESS_STATUS_TIMED_OUT, BETPRESS_STATUS_TIMED_OUT);
    betpress_register_string_for_translation('status-' . BETPRESS_STATUS_ACTIVE, BETPRESS_STATUS_ACTIVE);
    betpress_register_string_for_translation('status-' . BETPRESS_STATUS_PAST, BETPRESS_STATUS_PAST);
    betpress_register_string_for_translation('status-' . BETPRESS_STATUS_FAIL, BETPRESS_STATUS_FAIL);
    betpress_register_string_for_translation('status-' . BETPRESS_STATUS_PAID, BETPRESS_STATUS_PAID);
}

//create/modify db tables (triggered when the plugin's activated)
function betpress_generate_db_tables () {
    
    global $betpress_db_version;
    
    //do nothing if db is the same
    if (strcmp($betpress_db_version, get_option('bp_db_version')) === 0) {
        return;
    }
    
    global $wpdb;
    
    $table_names = array(
            0 => $wpdb->prefix . 'bp_sports',
            1 => $wpdb->prefix . 'bp_events',
            2 => $wpdb->prefix . 'bp_bet_events',
            3 => $wpdb->prefix . 'bp_bet_events_cats',
            4 => $wpdb->prefix . 'bp_bet_options',
            5 => $wpdb->prefix . 'bp_slips',
            6 => $wpdb->prefix . 'bp_leaderboards',
            7 => $wpdb->prefix . 'bp_paypal',
        );
        
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_names[0] (
            sport_id int(11) NOT NULL AUTO_INCREMENT,
            sport_sort_order int(11) NOT NULL,
            sport_name varchar(100) NOT NULL,
            PRIMARY KEY sport_id (sport_id),
            UNIQUE KEY (sport_name) 
        ) $charset_collate;
            CREATE TABLE $table_names[1] (
            event_id int(11) NOT NULL AUTO_INCREMENT,
            event_sort_order int(11) NOT NULL,
            event_name varchar(100) NOT NULL,
            sport_id int(11) NOT NULL,
            PRIMARY KEY event_id (event_id),
            UNIQUE KEY (event_name)
        ) $charset_collate;
            CREATE TABLE $table_names[2] (
            bet_event_id int(11) NOT NULL AUTO_INCREMENT,
            bet_event_sort_order int(11) NOT NULL,
            bet_event_name varchar(255) NOT NULL,
            deadline int(11) NOT NULL,
            is_active tinyint(1) NOT NULL DEFAULT 0,
            is_featured tinyint(1) NOT NULL DEFAULT 0,
            event_id int(11) NOT NULL,
            PRIMARY KEY bet_event_id (bet_event_id)
        ) $charset_collate;
            CREATE TABLE $table_names[3] (
            bet_event_cat_id int(11) NOT NULL AUTO_INCREMENT,
            bet_event_cat_sort_order int(11) NOT NULL,
            bet_event_cat_name varchar(255) NOT NULL,
            bet_event_id int(11) NOT NULL,
            PRIMARY KEY bet_event_cat_id (bet_event_cat_id)
        ) $charset_collate;
            CREATE TABLE $table_names[4] (
            bet_option_id int(11) NOT NULL AUTO_INCREMENT,
            bet_option_sort_order int(11) NOT NULL,
            bet_option_name varchar(255) NOT NULL,
            bet_option_odd double(10,2) NOT NULL,
            status varchar(11) NOT NULL, 
            bet_event_cat_id int(11) NOT NULL,
            PRIMARY KEY bet_option_id (bet_option_id)
        ) $charset_collate;
            CREATE TABLE $table_names[5] (
            slip_id int(11) NOT NULL AUTO_INCREMENT,
            user_id int(11) NOT NULL,
            bet_options_ids blob NOT NULL,
            status varchar(30) NOT NULL,
            stake double(10,2) NOT NULL,
            winnings double(10,2) NOT NULL,
            date int(11) NOT NULL,
            leaderboard_id int(11) DEFAULT NULL,
            PRIMARY KEY slip_id (slip_id)
        ) $charset_collate;
            CREATE TABLE $table_names[6] (
            leaderboard_id int(11) NOT NULL AUTO_INCREMENT,
            leaderboard_name varchar(255) NOT NULL,
            leaderboard_status varchar(6) NOT NULL,
            PRIMARY KEY leaderboard_id (leaderboard_id)
        ) $charset_collate;
            CREATE TABLE $table_names[7] (
            transaction_id int(11) NOT NULL AUTO_INCREMENT,
            transaction_message text NOT NULL,
            transaction_time int(11) NOT NULL,
            transaction_status varchar(4) NOT NULL,
            user_id int(11) NOT NULL,
            user_ip varchar(45) NOT NULL,
            points int(11) NOT NULL,
            PRIMARY KEY transaction_id (transaction_id)
        ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($sql);
    
    //save the db version
    update_option('bp_db_version', $betpress_db_version);
}

function betpress_insert_data_on_activation() {
    
    //add pages
    if (get_option('bp_pages_inserted') == '') {
        
        $pages_ids = array();

        $pages_ids [] = wp_insert_post(array(
            'post_title'    => __('Bettings', 'BetPress'),
            'post_type'     => 'page',
            'post_content'  => '[betpress_bettings]',
            'post_status'   => 'publish',
        ));

        $pages_ids [] = wp_insert_post(array(
            'post_title'    => __('Featured', 'BetPress'),
            'post_type'     => 'page',
            'post_content'  => '[betpress_featured]',
            'post_status'   => 'publish',
        ));

        $pages_ids [] = wp_insert_post(array(
            'post_title'    => __('Leaderboards', 'BetPress'),
            'post_type'     => 'page',
            'post_content'  => '[betpress_leaderboards]',
            'post_status'   => 'publish',
        ));

        $pages_ids [] = wp_insert_post(array(
            'post_title'    => __('Buy points', 'BetPress'),
            'post_type'     => 'page',
            'post_content'  => '[betpress_buy_points]',
            'post_status'   => 'publish',
        ));

        $pages_ids [] = wp_insert_post(array(
            'post_title'    => __('Slips', 'BetPress'),
            'post_type'     => 'page',
            'post_content'  => '[betpress_slips]',
            'post_status'   => 'publish',
        ));
        
        add_option('bp_pages_inserted', $pages_ids);
    }
    
    //add data from xml
    if ( ! betpress_get_sports() ) {
        
        betpress_insert_xml_data(
            BETPRESS_SPORTS_TO_ADD_DURING_ACTIVATION,
            BETPRESS_EVENTS_TO_ADD_DURING_ACTIVATION,
            BETPRESS_BET_EVENTS_TO_ADD_DURING_ACTIVATION,
            BETPRESS_BET_EVENTS_CATS_TO_ADD_DURING_ACTIVATION
        );
    }
    
    //add first leaderboard
    if ( ! betpress_get_leaderboards() ) {
        
        betpress_insert(
            'leaderboards',
            array(
                'leaderboard_name' => 'Leaderboard',
                'leaderboard_status' => BETPRESS_STATUS_ACTIVE,
            )
        );
        
        betpress_register_string_for_translation('lb-Leaderboard', 'Leaderboard');
        betpress_register_string_for_translation('status-' . BETPRESS_STATUS_ACTIVE, BETPRESS_STATUS_ACTIVE);
        betpress_register_string_for_translation('status-' . BETPRESS_STATUS_PAST, BETPRESS_STATUS_PAST);
    }
}

register_activation_hook(BETPRESS_MAIN_FILE_DIR, 'betpress_generate_db_tables');
register_activation_hook(BETPRESS_MAIN_FILE_DIR, 'betpress_default_settings');
register_activation_hook(BETPRESS_MAIN_FILE_DIR, 'betpress_insert_data_on_activation');

