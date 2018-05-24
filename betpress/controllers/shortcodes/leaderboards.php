<?php

//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}

function betpress_leaderboards_front_controller ($atts) {
    
    //set default attributes
    $attributes = shortcode_atts(
        array(
            'leaderboard' => BETPRESS_STATUS_ACTIVE,
            'rows' => 10,
            'top' => 'no',
        ),
        $atts
    );
    
    $page = isset($_GET['lb_page']) ? intval(betpress_sanitize($_GET['lb_page'])) : 1;
    
    if ($attributes['top'] !== 'no') {
            
        $limit = (int) $attributes['top'];
        $query_start = 0;
        
    } else {
           
        $limit = intval(betpress_sanitize($attributes['rows']));
        $query_start = ($page - 1) * $limit;
    
    }
    
    if ($attributes['leaderboard'] === BETPRESS_STATUS_ACTIVE) {
        
        $leaderboard = betpress_get_active_leaderboard();
        
        $total_rows = count(betpress_get_active_leaderboard_details(0, PHP_INT_MAX));
        
        $lb_details = betpress_get_active_leaderboard_details($query_start, $limit);
        
    } else {
        
        $leaderboard_name = betpress_sanitize($attributes['leaderboard']);
        
        $leaderboard = betpress_get_leaderboard_by_name($leaderboard_name);
        
        if ( ! $leaderboard ) {
            
            return;
            
        } else {
            
            $total_rows = count(betpress_get_leaderboard_details($leaderboard['leaderboard_id'], 0, PHP_INT_MAX));
            
            $lb_details = betpress_get_leaderboard_details($leaderboard['leaderboard_id'], $query_start, $limit);
            
        }
        
    }
    
    $last_page = intval($total_rows / $limit);
    
    ob_start();
    
    $pass['table_text'] = get_option('bp_lb_table_text_color');
    $pass['heading_bg'] = get_option('bp_lb_heading_bg_color');
    $pass['odd_bg'] = get_option('bp_lb_odd_bg_color');
    $pass['even_bg'] = get_option('bp_lb_even_bg_color');
    
    $pass['page_url'] = betpress_get_url(array('lb_page'));
    $pass['current_page'] = $page;
    $pass['next_page'] = $page + 1;
    $pass['previous_page'] = $page - 1;
    
    if ( (count($_GET) === 0) || ( (count($_GET) === 1) && (isset($_GET['lb_page'])) ) ) {
        
        $pass['symbol'] = '?';
        
    } else {
        
        $pass['symbol'] = '&amp;';
        
    }

    $pass['last_page'] = $total_rows % $limit === 0 ? $last_page : $last_page + 1;
    $pass['name'] = $leaderboard['leaderboard_name'];
    $pass['results'] = $lb_details;
    $pass['skip_paginator'] = $attributes['top'] !== 'no' ? true : false;
    betpress_get_view('leaderboard', 'shortcodes', $pass);
    
    return ob_get_clean();
}

add_shortcode('betpress_leaderboards', 'betpress_leaderboards_front_controller');