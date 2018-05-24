<?php

//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}

//display admin settings page
function betpress_settings_controller() {
    
    //really bad named param, think of "betpress" like "action"
    if (isset($_GET['betpress']) && empty($_POST)) {
        
        //do the action only if the button is clicked
        if ( (isset($_SERVER['HTTP_REFERER'])) && (strcmp(betpress_get_last_url_param(betpress_get_url()), 'settings-updated=true') !== 0) ) {

            switch ($_GET['betpress']) {

                case 'check_slips':

                    if (betpress_check_slips()) {

                        $pass['update_message'] = __('All awaiting slips were checked.', 'BetPress');
                        betpress_get_view('updated-message', 'admin', $pass);
                    } else {

                        $pass['error_message'] = __('Database error.', 'BetPress');
                        betpress_get_view('error-message', 'admin', $pass);
                    }

                    break;

                case 'check_all_slips':

                    if (betpress_check_slips(BETPRESS_VALUE_ALL)) {

                        $pass['update_message'] = __('All slips were checked.', 'BetPress');
                        betpress_get_view('updated-message', 'admin', $pass);
                    } else {

                        $pass['error_message'] = __('Database error.', 'BetPress');
                        betpress_get_view('error-message', 'admin', $pass);
                    }

                    break;

                case 'restart_points':

                    $starting_points = get_option('bp_starting_points');
                    $restart_points = betpress_update_wp('usermeta', array('meta_value' => $starting_points), array('meta_key' => 'bp_points'));

                    if (false !== $restart_points) {

                        $pass['update_message'] = __('All users\' points were restarted.', 'BetPress');
                        betpress_get_view('updated-message', 'admin', $pass);
                        
                    } else {

                        $pass['error_message'] = __('Database error.', 'BetPress');
                        betpress_get_view('error-message', 'admin', $pass);
                    }

                    break;

                default:
                    break;
            }
        }
    }
    
    if (isset($_GET['settings-updated']) && $_GET['settings-updated'] === 'true') {
        
        $pass['update_message'] = esc_attr__('Settings saved.', 'BetPress');
        betpress_get_view('updated-message', 'admin', $pass);
    }
 
    $pass['odd_types'] = array(
        BETPRESS_DECIMAL => __('Decimal', 'BetPress'),
        BETPRESS_FRACTION => __('Fraction', 'BetPress'),
        BETPRESS_AMERICAN => __('Moneyline', 'BetPress'),
    );
    $pass['page_url'] = betpress_get_url(array('betpress', 'settings-updated'));
    $pass['last_tab'] = isset($_COOKIE['betpress_admin_last_settings_tab']) ? betpress_sanitize($_COOKIE['betpress_admin_last_settings_tab']) : 'game-settings-tab';
    betpress_get_view('settings', 'admin', $pass);
}

