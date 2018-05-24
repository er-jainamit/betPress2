<?php

//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}

function betpress_points_change() {

    //codex says i MUST do this if
    if (is_admin() === true) {
        
        $user_ID = get_current_user_id();
        
        $user_db_points = get_user_meta($user_ID, 'bp_points', true);
        
        $user_points = ('' === $user_db_points) ? get_option('bp_starting_points') : $user_db_points;
        
        printf(__('Your points: %s', 'BetPress'), $user_points);
        
    }
    
    //codex says i MUST use wp_die
    wp_die();
}

add_action('wp_ajax_points_change', 'betpress_points_change');
add_action('wp_ajax_nopriv_points_change', 'betpress_points_change');

