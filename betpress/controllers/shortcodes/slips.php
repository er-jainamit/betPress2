<?php

//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}

function betpress_slips_front_controller ($atts) {
    
    if ( ! is_user_logged_in() ) {
        return;
    }
    
    $user_ID = get_current_user_id();
    
    //set default attributes
    $attributes = shortcode_atts(
        array(
            'awaiting' => BETPRESS_VALUE_YES,
            'winning' => BETPRESS_VALUE_YES,
            'losing' => BETPRESS_VALUE_YES,
            'canceled' => BETPRESS_VALUE_YES,
            'timed_out' => BETPRESS_VALUE_YES,
        ), $atts
    );
    
    ob_start();
    
    $pass['heading_bg'] = get_option('bp_slip_heading_bg_color');
    $pass['heading_text'] = get_option('bp_slip_heading_text_color');
    $pass['row_bg'] = get_option('bp_slip_row_bg_color');
    $pass['row_text'] = get_option('bp_slip_row_text_color');
    $pass['subrow_bg'] = get_option('bp_slip_subrow_bg_color');
    $pass['subrow_text'] = get_option('bp_slip_subrow_text_color');
    
    if ($attributes['awaiting'] === BETPRESS_VALUE_YES) {

        $pass['slips'] = betpress_get_user_awaiting_slips($user_ID);
        $pass['type'] = __('awaiting', 'BetPress');
        $pass['winnings'] = __('Possible winnings', 'BetPress');
        betpress_get_view('slips', 'shortcodes', $pass);
        
    }
    
    if ($attributes['winning'] === BETPRESS_VALUE_YES) {

        $pass['slips'] = betpress_get_user_winning_slips($user_ID);
        $pass['type'] = __('winning', 'BetPress');
        $pass['winnings'] = __('Winnings', 'BetPress');
        betpress_get_view('slips', 'shortcodes', $pass);
        
    }
    
    if ($attributes['losing'] === BETPRESS_VALUE_YES) {

        $pass['slips'] = betpress_get_user_losing_slips($user_ID);
        $pass['type'] = __('losing', 'BetPress');
        $pass['winnings'] = __('Possible winnings', 'BetPress');
        betpress_get_view('slips', 'shortcodes', $pass);
        
    }
    
    if ($attributes['canceled'] === BETPRESS_VALUE_YES) {

        $pass['slips'] = betpress_get_user_canceled_slips($user_ID);
        $pass['type'] = __('canceled', 'BetPress');
        $pass['winnings'] = __('Possible winnings', 'BetPress');
        betpress_get_view('slips', 'shortcodes', $pass);
        
    }
    
    if ($attributes['timed_out'] === BETPRESS_VALUE_YES) {

        $pass['slips'] = betpress_get_user_timed_out_slips($user_ID);
        $pass['type'] = __('timed out', 'BetPress');
        $pass['winnings'] = __('Possible winnings', 'BetPress');
        betpress_get_view('slips', 'shortcodes', $pass);
        
    }
    
    return ob_get_clean();
}

add_shortcode('betpress_slips', 'betpress_slips_front_controller');