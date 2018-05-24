<?php

//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}

function betpress_delete_bet_option() {

    //codex says i MUST do this if
    if (is_admin() === true) {

        $bet_option_ID = (int)betpress_sanitize($_POST['bet_option_id']);
        
        $user_ID = get_current_user_id();

        $unsubmitted_slip = betpress_get_user_unsubmitted_slip($user_ID);
        
        //just in case
        if (count($unsubmitted_slip) > 0) {

            //get current slip id
            $slip_ID = $unsubmitted_slip['slip_id'];
            
            //get current bet options from db
            $serialized_bet_options = $unsubmitted_slip['bet_options_ids'];
            
            //make them an array
            $unserialized_bet_options = unserialize($serialized_bet_options);
            
            //remove the bet
            if (isset($unserialized_bet_options[$bet_option_ID])) {
                unset($unserialized_bet_options[$bet_option_ID]);
            }
            
            //we will delete the slip if it's empty
            if ($unserialized_bet_options === array()) {
                
                $delete = betpress_delete(
                        'slips',
                        array(
                            'user_id' => $user_ID,
                            'status' => BETPRESS_STATUS_UNSUBMITTED,
                        )
                    );
                
                if (false === $delete) {
                    
                    _e('DB error.', 'BetPress');
                    
                } else {
                
                    _e('Your betting slip is empty.', 'BetPress');
                    
                }
                
            } else {

                //package to send to db
                $serialized_bet_options_updated = serialize($unserialized_bet_options);

                $update = betpress_update(
                        'slips',
                        array(
                            'bet_options_ids' => $serialized_bet_options_updated,
                        ),
                        array(
                            'slip_id' => $slip_ID,
                        )
                    );

                if (false === $update) {
                    
                    _e('DB error.', 'BetPress');
                    
                } else {
                    
                    //show the results           
                    betpress_render_bet_options($unserialized_bet_options);
                    
                }
            }
        }
    }
    
    //codex says i MUST use wp_die
    wp_die();
}

add_action( 'wp_ajax_delete_bet_option', 'betpress_delete_bet_option');
add_action( 'wp_ajax_nopriv_delete_bet_option', 'betpress_delete_bet_option');