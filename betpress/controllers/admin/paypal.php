<?php

//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}

function betpress_paypal_controller() {
    
    if ( (isset($_GET['user_id'])) && (get_userdata($_GET['user_id'])) ) {
        
        $user_ID = betpress_sanitize($_GET['user_id']);
        $pass['logs'] = betpress_get_paypal_logs_by_user($user_ID);
        
    } else {
        
        $pass['logs'] = betpress_get_paypal_logs();
        
    }
    
    $pass['users'] = betpress_get_users_with_paypal_logs();
    
    betpress_get_view('paypal-log', 'admin', $pass);
    
}

