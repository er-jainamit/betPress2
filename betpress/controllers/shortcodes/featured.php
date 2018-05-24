<?php

//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}

function betpress_featured_front_controller ($atts) {
    
    //set default attributes
    $attributes = shortcode_atts(
        array(
            'heading' => 'no',
            'border' => BETPRESS_VALUE_YES,
            'sort_col' => 'deadline',
            'sort_met' => 'ASC',
        ),
        $atts
    );
    
    $show_border = (BETPRESS_VALUE_YES === $attributes['border']) ? true : false;
    
    $lowercase_sort_col = strtolower($attributes['sort_col']);
    $uppercase_sort_met = strtoupper($attributes['sort_met']);
    
    $featured_bet_events = array();
    
    $allowed_cols = array(
        'deadline',
        'name',
        'event',
    );
    
    $allowed_mets = array(
        'ASC',
        'DESC',
    );
    
    //set defauls, just in case
    $sort_col = 'deadline';
    $sort_met = 'ASC';
    
    //set sort column
    if (in_array($lowercase_sort_col, $allowed_cols, true)) {
        
        switch ($lowercase_sort_col) {
            
            case 'deadline':
                
                $sort_col = 'deadline';
                break;
            
            case 'name':
                
                $sort_col = 'bet_event_name';
                break;
            
            case 'event':

                $sort_col = 'event_id';
                break;

            default:
                
                $sort_col = 'deadline';
                break;
        }
        
    } else {
        
        $sort_col = 'deadline';
        
    }
    
    //set sort asc/desc
    if (in_array($uppercase_sort_met, $allowed_mets, true)) {
        
        switch ($uppercase_sort_met) {
            
            case 'ASC':
                
                $sort_met = 'ASC';
                break;
            
            case 'DESC':
                
                $sort_met = 'DESC';
                break;

            default:
                
                $sort_met = 'ASC';
                break;
        }
        
    } else {
        
        $sort_met = 'ASC';
        
    }
    
    $bet_events = betpress_get_featured_bet_events($sort_col, $sort_met, get_option('bp_close_bets'));
    foreach ($bet_events as $bet_event) {
        
        //we dont want bet events without bet options
        if ( ! betpress_get_featured_bet_options($bet_event['bet_event_id']) ) {
            continue;
        }
        
        $featured_bet_events [$bet_event['bet_event_id']] ['options'] = betpress_get_featured_bet_options($bet_event['bet_event_id']);
        $featured_bet_events [$bet_event['bet_event_id']] ['name'] = $bet_event['bet_event_name'];
        
        switch (count($featured_bet_events [$bet_event['bet_event_id']] ['options'])) {
            
            case 2:

                $featured_bet_events [$bet_event['bet_event_id']] ['css_width'] = 50;
                break;
            
            case 4:

                $featured_bet_events [$bet_event['bet_event_id']] ['css_width'] = 25;
                
            default:
                
                $featured_bet_events [$bet_event['bet_event_id']] ['css_width'] = 33.33;
                break;
        }
    }
    
    ob_start();
    
    $pass['heading_bg'] = get_option('bp_featured_heading_bg_color');
    $pass['heading_text'] = get_option('bp_featured_heading_text_color');
    $pass['name_bg'] = get_option('bp_featured_name_bg_color');
    $pass['name_text'] = get_option('bp_featured_name_text_color');
    $pass['button_bg'] = get_option('bp_featured_button_bg_color');
    $pass['button_text'] = get_option('bp_featured_button_text_color');
    $pass['show_heading_row'] = (strcasecmp($attributes['heading'], BETPRESS_VALUE_YES)) === 0 ? true : false;
    $pass['show_border'] = $show_border;
    $pass['featured_bet_events'] = $featured_bet_events;
    betpress_get_view('featured', 'shortcodes', $pass);
    
    return ob_get_clean();
}

add_shortcode('betpress_featured', 'betpress_featured_front_controller');