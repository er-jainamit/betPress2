<?php

//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}

function betpress_paypal_front_controller ($atts) {
    
    if ( ! is_user_logged_in() ) {
        return;
    }
    
    ob_start();

    betpress_get_view('buy-points', 'shortcodes');
        
    return ob_get_clean();
}

add_shortcode('betpress_buy_points', 'betpress_paypal_front_controller');