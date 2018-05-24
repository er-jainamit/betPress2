<?php

//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}

function betpress_leaderboards_controller() {
    
    if ( ( isset($_GET['lb']) ) && ( $lb = betpress_get_leaderboard(betpress_sanitize($_GET['lb'])) ) ) {
        
        $lb_ID = $lb['leaderboard_id'];
        
        $pass['results'] = betpress_is_active_leaderboard($lb_ID) ? betpress_get_active_leaderboard_details() : betpress_get_leaderboard_details($lb_ID);
        $pass['leaderboard'] = $lb;
        $pass['back_url'] = betpress_get_url(array('lb'));
        betpress_get_view('leaderboard-details', 'admin', $pass);
        
    } else if ( ( isset($_GET['edit_lb']) ) && ( $lb = betpress_get_leaderboard(betpress_sanitize($_GET['edit_lb'])) ) ) {
        
        if (isset($_POST['editing_leaderboard'])) {
            
            $lb_name = betpress_sanitize($_POST['leaderboard_name']);
            
            $errors = array();
            
            if (betpress_is_lb_exists($lb_name, $lb['leaderboard_id'])) {
            
                $errors [] = __('A leaderboard with that name already exists.', 'BetPress');
            }
            
            if (strlen($lb_name) < 1) {
                
                $errors [] = __('Leaderboard name must NOT be empty.', 'BetPress');
            }
            
            if ($errors) {
                
                foreach ($errors as $error) {
                    
                    $pass['error_message'] = $error;
                    betpress_get_view('error-message', 'admin', $pass);
                    
                }
            
            } else {

                $is_updated = betpress_update(
                        'leaderboards',
                        array(
                            'leaderboard_name' => $lb_name,
                        ),
                        array(
                            'leaderboard_id' => $lb['leaderboard_id'],
                        )
                );

                if ($is_updated !== false) {
                    
                    betpress_register_string_for_translation('lb-' . $lb_name, $lb_name);

                    $pass['update_message'] = __('Leaderboard updated.', 'BetPress');
                    betpress_get_view('updated-message', 'admin', $pass);
                } else {

                    $pass['error_message'] = __('Database error.', 'BetPress');
                    betpress_get_view('error-message', 'admin', $pass);
                }
            }
        }
        
        $pass['leaderboard'] = betpress_get_leaderboard(betpress_sanitize($_GET['edit_lb']));
        $pass['back_url'] = betpress_get_url(array('edit_lb'));
        betpress_get_view('edit-leaderboard', 'admin', $pass);
        
    } else {
        
        if (isset($_POST['adding_leaderboard'])) {

            $lb_name = betpress_sanitize($_POST['leaderboard_name']);

            $errors = array();

            if (strlen($lb_name) < 1) {

                $errors [] = __('Name must NOT be empty.', 'BetPress');
            }
            
            if (betpress_is_lb_exists($lb_name)) {
            
                $errors [] = __('A leaderboard with that name already exists.', 'BetPress');
            }

            if ( ! $errors ) {

                $db_errors = false;
                
                //check all slips to make sure all users points are up to date
                if ( ! betpress_check_slips(BETPRESS_VALUE_ALL) ) {
                    $db_errors = true;
                }
                
                //cancel all awaiting slips
                $awaiting_slips = betpress_get_awaiting_slips();
                
                foreach ($awaiting_slips as $slip) {
                    
                    $user_ID = $slip['user_id'];
                    $current_points = get_user_meta($user_ID, 'bp_points', true);
                    $updated_points = $current_points + $slip['stake'];
                    
                    //update users points
                    update_user_meta($user_ID, 'bp_points', (string)$updated_points);

                    //check if the update took effect
                    if (strcmp(get_user_meta($user_ID, 'bp_points', true), (string)$updated_points) !== 0) {
                        $db_errors = true;
                    }
                    
                    $update_slip = betpress_update(
                        'slips',
                        array(
                            'status' => BETPRESS_STATUS_TIMED_OUT,
                        ),
                        array(
                            'slip_id' => $slip['slip_id'],
                        )
                    );
                    
                    if (false === $update_slip) {
                        $db_errors = true;
                    }
                }

                //close the leaderboard storing all users points
                $current_leaderboard = betpress_get_current_leaderboard();
                $leaderboard_ID = $current_leaderboard['leaderboard_id'];

                $users = betpress_get_users_with_points();

                foreach ($users as $user) {

                    $user_ID = $user['user_id'];
                    $meta_key = 'bp_lb_' . $leaderboard_ID;
                    $meta_value = $user['meta_value'];
                    if ( ! add_user_meta($user_ID, $meta_key, $meta_value, true) ) {
                        $db_errors = true;
                    }
                }

                $close_old_leaderboard =
                    betpress_update(
                        'leaderboards',
                        array(
                            'leaderboard_status' => BETPRESS_STATUS_PAST,
                        ),
                        array(
                            'leaderboard_status' => BETPRESS_STATUS_ACTIVE,
                        )
                    );

                if (false === $close_old_leaderboard) {

                    $db_errors = true;
                    
                }

                //open new leaderboard
                $open_leaderboard =
                        betpress_insert(
                            'leaderboards',
                            array(
                                'leaderboard_name' => $lb_name,
                                'leaderboard_status' => BETPRESS_STATUS_ACTIVE,
                            )
                        );

                if ( ! $open_leaderboard ) {

                    $db_errors = true;
                }

                //restart all users points
                $starting_points = get_option('bp_starting_points');
                $restart_points = betpress_update_wp('usermeta', array('meta_value' => $starting_points), array('meta_key' => 'bp_points'));

                if (false === $restart_points) {

                    $db_errors = true;
                }

                //restart all users buyed points
                $restart_points_buyed = betpress_update_wp('usermeta', array('meta_value' => 0), array('meta_key' => 'bp_points_buyed'));

                if (false === $restart_points_buyed) {

                    $db_errors = true;
                }

                if ( ! $db_errors ) {

                    $pass['update_message'] = __('Leaderboard added, previous leaderboard closed and users points restarted.', 'BetPress');
                    betpress_get_view('updated-message', 'admin', $pass);
                    
                } else {

                    $pass['error_message'] = __('Database error.', 'BetPress');
                    betpress_get_view('error-message', 'admin', $pass);
                }
                
            } else {

                foreach ($errors as $error) {
                    $pass['error_message'] = $error;
                    betpress_get_view('error-message', 'admin', $pass);
                }
            }
        }

        $pass['page_url'] = betpress_get_url();
        $pass['leaderboards'] = betpress_get_leaderboards();
        betpress_get_view('leaderboards', 'admin', $pass);
        betpress_get_view('helper', 'admin');
    }
}

