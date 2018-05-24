<?php

//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}

function betpress_submit_bet_slip() {

    //codex says i MUST do this if
    if (is_admin() === true) {
        
        $user_ID = get_current_user_id();
        
        $users_db_points = get_user_meta($user_ID, 'bp_points', true);
        
        $users_points = $users_db_points === '' ? get_option('bp_starting_points') : $users_db_points;
        
        $errors = array();
        
        $bet_stake = betpress_sanitize($_POST['bet_stake']);
        
        $min_stake = get_option('bp_min_stake');
        
        $max_stake = get_option('bp_max_stake');
        
        $slip = betpress_get_user_unsubmitted_slip($user_ID);
        
        if ( ! $slip ) {
            
            $errors [] = __('Select bet option first.', 'BetPress');
            
        } else {
            
            $bet_options_ids = unserialize($slip['bet_options_ids']);
            
            //check for passed deadline
            foreach ($bet_options_ids as $bet_option_ID => $bet_option_odd) {

                $bet_option_details = betpress_get_bet_option($bet_option_ID);

                $seconds_to_close_bets_earlier = (int) get_option('bp_close_bets');

                $bet_event_close_time = $bet_option_details['deadline'] - $seconds_to_close_bets_earlier;
                
                if ($bet_event_close_time < time()) {
                    
                    $errors [$bet_option_details['bet_event_name']] = sprintf(
                            __('The deadline for %s has passed.', 'BetPress'),
                            $bet_option_details['bet_event_name']
                        );
                    
                }
            }
        
            //check for same slip
            $user_awaiting_slips = betpress_get_user_awaiting_slips($user_ID);
            
            foreach ($user_awaiting_slips as $awaiting_slip) {
                
                $awaiting_slip_bet_options = unserialize($awaiting_slip['bet_options_ids']);
                
                $differences = array_diff_assoc($bet_options_ids, $awaiting_slip_bet_options);
                
                $count_awaiting_slip = count($awaiting_slip_bet_options);
                
                $count_unsubmitted_slip = count($bet_options_ids);
                
                if ( ($differences === array()) && ($count_awaiting_slip === $count_unsubmitted_slip) ) {
                    
                    $errors ['same_slip'] = __('You already have a slip with these options.', 'BetPress');
                }
            }
            
            if (get_option('bp_only_int_stakes') === BETPRESS_VALUE_YES) {

                if ($bet_stake - intval($bet_stake) !== 0) {

                    $errors [] = __('Stake must be whole number.', 'BetPress');
                }
            }

            if ($users_points < $bet_stake) {

                $errors [] = __('You don\'t have enough points.', 'BetPress');
            }

            if ($bet_stake < $min_stake) {

                $errors [] = sprintf(__('Minimum allowed stake is %s', 'BetPress'), $min_stake);
                
            } else {

                $min_stake_ok = true;
            }

            if ($bet_stake > $max_stake) {

                $errors [] = sprintf(__('Maximum allowed stake is %s', 'BetPress'), $max_stake);
            }

            if ($bet_stake <= 0 && isset($min_stake_ok)) {

                $errors [] = __('The stake must be greater than zero.', 'BetPress');
            }
        }
        
        if ($errors) {
            
            //show errors
            foreach($errors as $error) {
                
                $pass['error_message'] = $error;
                betpress_get_view('error-message', '', $pass);
            }

            //take bet options and make them array
            $bet_option_ids = unserialize($slip['bet_options_ids']);

            //show the slip
            if ($slip) {
                betpress_render_bet_options($bet_option_ids);
            }
            
        } else {
            
            //calculate possible winnings
            $possible_winnings = $bet_stake;
            
            $bet_options_ids = unserialize($slip['bet_options_ids']);
            
            foreach ($bet_options_ids as $bet_option_ID => $bet_option_odd) {
                
                $possible_winnings *= $bet_option_odd;
            }
            
            $possible_winnings_rounded = betpress_floordec($possible_winnings);
                        
            //calculate new points
            $bet_stake_rounded = betpress_floordec($bet_stake);
            $updated_points = $users_points - $bet_stake_rounded;
            
            //update the points
            update_user_meta($user_ID, 'bp_points', (string)$updated_points);
            
            //make sure its updated
            if (strcmp(get_user_meta($user_ID, 'bp_points', true), (string)$updated_points) !== 0) {
                wp_die('DB error.');
            }
            
            $active_leaderboard = betpress_get_active_leaderboard();
            
            //update the slip
            $is_updated = betpress_update(
                    'slips',
                    array(
                        'status' => BETPRESS_STATUS_AWAITING,
                        'winnings' => $possible_winnings_rounded,
                        'stake' => $bet_stake_rounded,
                        'date' => time(),
                        'leaderboard_id' => $active_leaderboard['leaderboard_id'],
                    ),
                    array(
                        'user_id' => $user_ID,
                        'status' => BETPRESS_STATUS_UNSUBMITTED,
                    )
                );
            
            if (false !== $is_updated) {
                
                $pass['success_message'] = esc_attr__('Your bet slip has been submitted.', 'BetPress');
                betpress_get_view('success-message', '', $pass);
                
            } else {
                wp_die('DB error.');
            }
        }
    }
    //codex says to use wp_die in the end
    wp_die();
}

add_action('wp_ajax_submit_bet_slip', 'betpress_submit_bet_slip');
add_action('wp_ajax_nopriv_submit_bet_slip', 'betpress_submit_bet_slip');