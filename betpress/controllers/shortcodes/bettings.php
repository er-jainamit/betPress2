<?php

//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}

function betpress_bettings_front_controller ($atts) {
    
    //set default attributes
    $attributes = shortcode_atts(
        array(
            'sport' => BETPRESS_VALUE_ALL,
            'toggle' => 1,
        ), $atts
    );
    
    ob_start();
    
    $active_events = false;
    
    $data = array();
    
    if (BETPRESS_VALUE_ALL == $attributes['sport']) {

        $sports = betpress_get_sports();
        foreach ($sports as $sport) {

            $data [$sport['sport_id']] = betpress_get_sport_data($sport, get_option('bp_close_bets'));
            
            if ($data [$sport['sport_id']] ['count_active_events'] > 0) {
                $active_events = true;
            }
            
        }
        
    } else {
        
        $sport = betpress_get_sport_by_name($attributes['sport']);
        $data [$sport['sport_id']] = betpress_get_sport_data($sport, get_option('bp_close_bets'));
            
        if ($data [$sport['sport_id']] ['count_active_events'] > 0) {
            $active_events = true;
        }
        
    }

    $pass['sports'] = $data;
    $pass['sport_title_bg'] = get_option('bp_sport_title_bg_color');
    $pass['sport_title_text'] = get_option('bp_sport_title_text_color');
    $pass['sport_container_bg'] = get_option('bp_sport_container_bg_color');
    $pass['event_title_bg'] = get_option('bp_event_title_bg_color');
    $pass['event_title_text'] = get_option('bp_event_title_text_color');
    $pass['event_container_bg'] = get_option('bp_event_container_bg_color');
    $pass['bet_event_title_bg'] = get_option('bp_bet_event_title_bg_color');
    $pass['bet_event_title_text'] = get_option('bp_bet_event_title_text_color');
    $pass['cat_title_bg'] = get_option('bp_cat_title_bg_color');
    $pass['cat_title_text'] = get_option('bp_cat_title_text_color');
    $pass['cat_container_bg'] = get_option('bp_cat_container_bg_color');
    $pass['button_bg'] = get_option('bp_button_bg_color');
    $pass['button_text'] = get_option('bp_button_text_color');
    $pass['min_children_to_show_toggle'] = (int) $attributes['toggle'];
    $pass['active_bettings'] = $active_events;
    betpress_get_view('bettings', 'shortcodes', $pass);
    
    return ob_get_clean();
}

add_shortcode('betpress_bettings', 'betpress_bettings_front_controller');