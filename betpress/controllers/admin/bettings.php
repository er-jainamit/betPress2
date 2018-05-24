<?php

//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}

//render admin sports and events page
function betpress_bettings_controller() {
        
    $pass['page_url'] = betpress_get_url();
        
    if (isset($_POST['adding_event'])) {
        
        $event_name = betpress_sanitize($_POST['event_name']);
        
        $sport_id = (int)betpress_sanitize($_POST['sport_id']);
        
        $errors = array();
        
        $event_exists = betpress_is_event_exists($event_name);
        
        if ($event_exists) {
            
            $errors [] = __('An event with that name already exists.', 'BetPress');
        }
        
        if (strlen($event_name) < 1) {
            
            $errors [] = __('Event name must NOT be empty.', 'BetPress');
        }
        
        if ($errors) {
            
            foreach ($errors as $error) {
                
                $pass['error_message'] = $error;
                
                betpress_get_view('error-message', 'admin', $pass);
            }
            
        } else {
            
            $max_order = betpress_get_events_max_order($sport_id);

            $is_inserted = betpress_insert(
                'events',
                array(
                    'event_name' => $event_name,
                    'event_sort_order' => ++ $max_order,
                    'sport_id' => $sport_id,
                )
            );
            
            if ($is_inserted) {
                
                betpress_register_string_for_translation('event-' . $event_name, $event_name);
                
                $pass['update_message'] = __('Event added.', 'BetPress');
                betpress_get_view('updated-message', 'admin', $pass);
        
            } else {
                
                $pass['error_message'] = __('Database error.', 'BetPress');
                betpress_get_view('error-message', 'admin', $pass);
            }
        }     
    }
    
    if (isset($_POST['adding_sport'])) {
        
        $sport_name = betpress_sanitize($_POST['sport_name']);
        
        $errors = array();
        
        if (betpress_is_sport_exists($sport_name)) {
            
            $errors [] = __('A sport with that name already exists.', 'BetPress');
        }
        
        if (strlen($sport_name) < 1) {
            
            $errors [] = __('Sport name must NOT be empty.', 'BetPress');
        }
        
        if ($errors) {
            
            foreach ($errors as $error) {
                
                $pass['error_message'] = $error;
                betpress_get_view('error-message', 'admin', $pass);
            }
            
        } else {
            
            $max_order = betpress_get_sports_max_order();

            $is_inserted = betpress_insert(
                'sports',
                array(
                    'sport_name' => $sport_name,
                    'sport_sort_order' => ++ $max_order,
                )
            );
            
            if ($is_inserted) {
                
                betpress_register_string_for_translation('sport-' . $sport_name, $sport_name);
                
                $pass['update_message'] = __('Sport added.', 'BetPress');
                betpress_get_view('updated-message', 'admin', $pass);       
            } else {
                
                $pass['error_message'] = __('Database error.', 'BetPress');               
                betpress_get_view('error-message', 'admin', $pass);
            }
        }     
    }
    
    if ( (isset($_GET['edit_event'])) && ($event = betpress_get_event(betpress_sanitize($_GET['edit_event']))) ) {
        
        if (isset($_POST['editing_event'])) {
            
            $event_name = betpress_sanitize($_POST['event_name']);
            
            $sport_ID = (int)betpress_sanitize($_POST['sport_id']);
            
            $errors = array();
        
            if (betpress_is_event_exists($event_name, $event['event_id'])) {
            
                $errors [] = __('An event with that name already exists.', 'BetPress');
            }
            
            if (strlen($event_name) < 1) {
                
                $errors [] = __('Event name must NOT be empty.', 'BetPress');
            }
            
            if ($sport_ID < 1) {
                
                $errors [] = __('Wrong sport.', 'BetPress');
            }
            
            if ($errors) {
                
                foreach ($errors as $error) {
                    
                    $pass['error_message'] = $error;
                    betpress_get_view('error-message', 'admin', $pass);
                    
                }
            
            } else {
                
                if ($sport_ID != $event['sport_id']) {
                    
                    $max_order = betpress_get_min_max_order('events', 'MAX', 'sport_id', $sport_ID);
                    $order = $max_order + 1;
                    
                } else {
                    
                    $order = $event['event_sort_order'];
                }

                $is_updated = betpress_update(
                        'events',
                        array(
                            'event_name' => $event_name,
                            'sport_id' => $sport_ID,
                            'event_sort_order' => $order,
                        ),
                        array(
                            'event_id' => $event['event_id'],
                        )
                );

                if ($is_updated !== false) {
                    
                    betpress_register_string_for_translation('event-' . $event_name, $event_name);

                    $pass['update_message'] = __('Event updated.', 'BetPress');
                    betpress_get_view('updated-message', 'admin', $pass);
                } else {

                    $pass['error_message'] = __('Database error.', 'BetPress');
                    betpress_get_view('error-message', 'admin', $pass);
                }
            }
        }
        
        $pass['back_url'] = betpress_get_url(array('edit_event'));
        $pass['event'] = betpress_get_event(betpress_sanitize($_GET['edit_event']));
        $pass['sports'] = betpress_get_sports();
        
        betpress_get_view('edit-event', 'admin', $pass);
        
    } else if ( (isset($_GET['delete_event'])) && ($event = betpress_get_event(betpress_sanitize($_GET['delete_event']))) 
            && (isset($_GET['noheader'])) && ($_GET['noheader'] === 'true') ) {
        
        $del_event = betpress_delete('events', array('event_id' => $event['event_id']));

        if ($del_event) {

            $bet_events_to_del = betpress_get_bet_events($event['event_id']);
            foreach ($bet_events_to_del as $bet_ev) {

                $deleted_bet_options_ids = array();
                
                $cats_to_del = betpress_get_categories($bet_ev['bet_event_id']);
                foreach ($cats_to_del as $cat) {
                    
                    $bet_options_to_delete = betpress_get_bet_options($cat['bet_event_cat_id']);
                    foreach ($bet_options_to_delete as $bet_option) {
                        
                        $deleted_bet_options_ids [] = $bet_option['bet_option_id'];
                        
                    }
                    
                    betpress_delete('bet_options', array('bet_event_cat_id' => (int) $cat['bet_event_cat_id']));
                    
                }
                
                betpress_delete_bet_options_from_unsubmitted_slips($deleted_bet_options_ids);

                betpress_delete('bet_events_cats', array('bet_event_id' => (int) $bet_ev['bet_event_id']));
                
            }
            
            betpress_delete('bet_events', array('event_id' => $event['event_id']));
            
        }

        wp_redirect(betpress_get_url(array('noheader', 'delete_event')));
        exit();
        
    } else if ( (isset($_GET['move_up_event'])) && ($event = betpress_get_event(betpress_sanitize($_GET['move_up_event'])))
            && (isset($_GET['noheader'])) && ($_GET['noheader'] === 'true') ) {
        
        $current_order = $event['event_sort_order'];
        $min_order = betpress_get_min_max_order('events', 'MIN', 'sport_id', $event['sport_id']);
        
        if ($min_order != $current_order) {          
            
            $lower_order_event = betpress_get_lower_order($current_order, 'events', 'sport_id', $event['sport_id']);
            $lower_order = $lower_order_event['event_sort_order'];
            betpress_update('events', array('event_sort_order' => $lower_order), array('event_id' => $event['event_id']));
            betpress_update('events', array('event_sort_order' => $current_order), array('event_id' => $lower_order_event['event_id']));
            
        }
        
        wp_redirect(betpress_get_url(array('noheader', 'move_up_event')));
        exit();
        
    } else if ( (isset($_GET['move_down_event'])) && ($event = betpress_get_event(betpress_sanitize($_GET['move_down_event'])))
            && (isset($_GET['noheader'])) && ($_GET['noheader'] === 'true') ) {
        
        $current_order = $event['event_sort_order'];
        $max_order = betpress_get_min_max_order('events', 'MAX', 'sport_id', $event['sport_id']);
        
        if ($max_order != $current_order) {          
            
            $higher_order_event = betpress_get_higher_order($current_order, 'events', 'sport_id', $event['sport_id']);
            $higher_order = $higher_order_event['event_sort_order'];
            betpress_update('events', array('event_sort_order' => $higher_order), array('event_id' => $event['event_id']));
            betpress_update('events', array('event_sort_order' => $current_order), array('event_id' => $higher_order_event['event_id']));
            
        }
        
        wp_redirect(betpress_get_url(array('noheader', 'move_down_event')));
        exit();
        
    } else if ( (isset($_GET['edit_sport'])) && ($sport = betpress_get_sport(betpress_sanitize($_GET['edit_sport']))) ) {
        
        if (isset($_POST['editing_sport'])) {
            
            $sport_name = betpress_sanitize($_POST['sport_name']);
            
            $errors = array();
            
            if (betpress_is_sport_exists($sport_name, $sport['sport_id'])) {
            
                $errors [] = __('A sport with that name already exists.', 'BetPress');
            }
            
            if (strlen($sport_name) < 1) {
                
                $errors [] = __('Sport name must NOT be empty.', 'BetPress');
            }
            
            if ($errors) {
                
                foreach ($errors as $error) {
                    
                    $pass['error_message'] = $error;
                    betpress_get_view('error-message', 'admin', $pass);
                    
                }
            
            } else {

                $is_updated = betpress_update(
                        'sports',
                        array(
                            'sport_name' => $sport_name,
                        ),
                        array(
                            'sport_id' => $sport['sport_id'],
                        )
                );

                if ($is_updated !== false) {
                    
                    betpress_register_string_for_translation('sport-' . $sport_name, $sport_name);

                    $pass['update_message'] = __('Sport updated.', 'BetPress');
                    betpress_get_view('updated-message', 'admin', $pass);
                } else {

                    $pass['error_message'] = __('Database error.', 'BetPress');
                    betpress_get_view('error-message', 'admin', $pass);
                }
            }
        }
        
        $pass['back_url'] = betpress_get_url(array('edit_sport'));
        $pass['sport'] = betpress_get_sport(betpress_sanitize($_GET['edit_sport']));
        
        betpress_get_view('edit-sport', 'admin', $pass);
        
    } else if ( (isset($_GET['delete_sport'])) && ($sport = betpress_get_sport(betpress_sanitize($_GET['delete_sport'])))
            && (isset($_GET['noheader'])) && ($_GET['noheader'] === 'true') ) {
        
        $del_sport = betpress_delete('sports', array('sport_id' => $sport['sport_id']));
        
        if ($del_sport) {
            
            $events_to_del = betpress_get_events_by_sport($sport['sport_id']);
            foreach ($events_to_del as $ev) {
                
                $bet_events_to_del = betpress_get_bet_events($ev['event_id']);
                foreach ($bet_events_to_del as $bet_ev) {
                    
                    $deleted_bet_options_ids = array();
                    
                    $cats_to_del = betpress_get_categories($bet_ev['bet_event_id']);
                    foreach ($cats_to_del as $cat) {
                    
                        $bet_options_to_delete = betpress_get_bet_options($cat['bet_event_cat_id']);
                        foreach ($bet_options_to_delete as $bet_option) {
                        
                            $deleted_bet_options_ids [] = $bet_option['bet_option_id'];
                        
                        }
                        
                        betpress_delete('bet_options', array('bet_event_cat_id' => $cat['bet_event_cat_id']));
                        
                    }
                    
                    betpress_delete_bet_options_from_unsubmitted_slips($deleted_bet_options_ids);
                    
                    betpress_delete('bet_events_cats', array('bet_event_id' => $bet_ev['bet_event_id']));
                    
                }
                
                betpress_delete('bet_events', array('event_id' => $ev['event_id']));
                
            }
            
            betpress_delete('events', array('sport_id' => $sport['sport_id']));
            
        }
        
        wp_redirect(betpress_get_url(array('noheader', 'delete_sport')));
        exit();
        
    } else if ( (isset($_GET['move_up_sport'])) && ($sport = betpress_get_sport(betpress_sanitize($_GET['move_up_sport'])))
            && (isset($_GET['noheader'])) && ($_GET['noheader'] === 'true') ) {
        
        $current_order = $sport['sport_sort_order'];
        $min_order = betpress_get_min_max_order('sports', 'MIN');
        
        if ($min_order != $current_order) {          
            
            $lower_order_sport = betpress_get_lower_order($current_order, 'sports');
            $lower_order = $lower_order_sport['sport_sort_order'];
            betpress_update('sports', array('sport_sort_order' => $lower_order), array('sport_id' => $sport['sport_id']));
            betpress_update('sports', array('sport_sort_order' => $current_order), array('sport_id' => $lower_order_sport['sport_id']));
            
        }
        
        wp_redirect(betpress_get_url(array('noheader', 'move_up_sport')));
        exit();
        
    } else if ( (isset($_GET['move_down_sport'])) && ($sport = betpress_get_sport(betpress_sanitize($_GET['move_down_sport'])))
            && (isset($_GET['noheader'])) && ($_GET['noheader'] === 'true') ) {
        
        $current_order = $sport['sport_sort_order'];
        $max_order = betpress_get_min_max_order('sports', 'MAX');
        
        if ($max_order != $current_order) {          
            
            $higher_order_sport = betpress_get_higher_order($current_order, 'sports');
            $higher_order = $higher_order_sport['sport_sort_order'];
            betpress_update('sports', array('sport_sort_order' => $higher_order), array('sport_id' => $sport['sport_id']));
            betpress_update('sports', array('sport_sort_order' => $current_order), array('sport_id' => $higher_order_sport['sport_id']));
            
        }
        
        wp_redirect(betpress_get_url(array('noheader', 'move_down_sport')));
        exit();
        
    } else if ( (isset($_GET['edit_bet_event'])) && ($bet_event = betpress_get_bet_event(betpress_sanitize($_GET['edit_bet_event'])))
            && (isset($_GET['event'])) && ($event = betpress_get_event(betpress_sanitize($_GET['event']))) ) {
        
        if (isset($_POST['editing_bet_event'])) {

            $errors = array();

            $bet_event_name = betpress_sanitize($_POST['bet_event_name']);
            
            $bet_event_id = $bet_event['bet_event_id'];
            
            $event_ID = $event['event_id'];
            
            if (betpress_is_bet_event_name_exists($bet_event_name, $event_ID, $bet_event_id)) {

                $errors [] = __('Bet event already exists, pick another name.', 'BetPress');
            }

            if (strlen($bet_event_name) < 1) {

                $errors [] = __('Bet event name must NOT be empty.', 'BetPress');
            }

            //check is weird but otherwise strtotime will generate an error (at least php doc says so)
            if ( ( $deadline = strtotime(betpress_sanitize($_POST['deadline'])) ) === false ) {

                $errors [] = __('Not a valid date.', 'BetPress');
            }

            if ($errors) {

                foreach ($errors as $error) {

                    $pass['error_message'] = $error;
                    betpress_get_view('error-message', 'admin', $pass);
                }
                
            } else {

                $is_updated = betpress_update(
                        'bet_events',
                        array(
                            'bet_event_name' => $bet_event_name,
                            'deadline' => $deadline,
                        ),
                        array(
                            'bet_event_id' => $bet_event['bet_event_id'],
                        )
                );

                if ($is_updated !== false) {
                    
                    betpress_register_string_for_translation('bet-event-' . $bet_event_name, $bet_event_name);

                    $pass['update_message'] = __('Bet event updated.', 'BetPress');
                    betpress_get_view('updated-message', 'admin', $pass);
                } else {

                    $pass['error_message'] = __('Database error.', 'BetPress');
                    betpress_get_view('error-message', 'admin', $pass);
                }
            }
        }
        
        $pass['back_url'] = betpress_get_url(array('edit_bet_event'));
        $pass['bet_event'] = betpress_get_bet_event($bet_event['bet_event_id']);
        
        betpress_get_view('edit-bet-event', 'admin', $pass);
        
    } else if ( (isset($_GET['feature_off_bet_event'])) && ($bet_event = betpress_get_bet_event(betpress_sanitize($_GET['feature_off_bet_event']))) 
            && (isset($_GET['noheader'])) && ($_GET['noheader'] === 'true') ) {
        
        betpress_update('bet_events', array('is_featured' => 0), array('bet_event_id' => (int)$bet_event['bet_event_id']));
        
        wp_redirect(betpress_get_url(array('noheader', 'feature_off_bet_event')));
        exit();
        
    } else if ( (isset($_GET['feature_on_bet_event'])) && ($bet_event = betpress_get_bet_event(betpress_sanitize($_GET['feature_on_bet_event']))) 
            && (isset($_GET['noheader'])) && ($_GET['noheader'] === 'true') ) {
        
        betpress_update('bet_events', array('is_featured' => 1), array('bet_event_id' => (int)$bet_event['bet_event_id']));
        
        wp_redirect(betpress_get_url(array('noheader', 'feature_on_bet_event')));
        exit();
        
    } else if ( (isset($_GET['deactivate_bet_event'])) && ($bet_event = betpress_get_bet_event(betpress_sanitize($_GET['deactivate_bet_event']))) 
            && (isset($_GET['noheader'])) && ($_GET['noheader'] === 'true') ) {
        
        betpress_update('bet_events', array('is_active' => 0), array('bet_event_id' => (int)$bet_event['bet_event_id']));
        
        wp_redirect(betpress_get_url(array('noheader', 'deactivate_bet_event')));
        exit();
        
    } else if ( (isset($_GET['activate_bet_event'])) && ($bet_event = betpress_get_bet_event(betpress_sanitize($_GET['activate_bet_event']))) 
            && (isset($_GET['noheader'])) && ($_GET['noheader'] === 'true') ) {
        
        betpress_update('bet_events', array('is_active' => 1), array('bet_event_id' => (int)$bet_event['bet_event_id']));
        
        wp_redirect(betpress_get_url(array('noheader', 'activate_bet_event')));
        exit();
        
    } else if ( (isset($_GET['delete_bet_event'])) && ($bet_event = betpress_get_bet_event(betpress_sanitize($_GET['delete_bet_event']))) 
            && (isset($_GET['noheader'])) && ($_GET['noheader'] === 'true') ) {
        
        $del_bet_ev = betpress_delete('bet_events', array('bet_event_id' => (int)$bet_event['bet_event_id']));
        
        if ($del_bet_ev) {
            
            $deleted_bet_options_ids = array();
            
            $cats_to_del = betpress_get_categories($bet_event['bet_event_id']);
            foreach ($cats_to_del as $cat) {
                    
                $bet_options_to_delete = betpress_get_bet_options($cat['bet_event_cat_id']);
                foreach ($bet_options_to_delete as $bet_option) {
                        
                    $deleted_bet_options_ids [] = $bet_option['bet_option_id'];
                        
                }
                
                betpress_delete('bet_options', array('bet_event_cat_id' => $cat['bet_event_cat_id']));
                
            }
                
            betpress_delete_bet_options_from_unsubmitted_slips($deleted_bet_options_ids);
            
            betpress_delete('bet_events_cats', array('bet_event_id' => (int)$bet_event['bet_event_id']));
            
        }
        
        wp_redirect(betpress_get_url(array('noheader', 'delete_bet_event')));
        exit();
        
    } else if ( (isset($_GET['move_up_bet_event'])) && ($bet_event = betpress_get_bet_event(betpress_sanitize($_GET['move_up_bet_event']))) 
            && (isset($_GET['noheader'])) && ($_GET['noheader'] === 'true') ) {
        
        
        $current_order = $bet_event['bet_event_sort_order'];
        $min_order = betpress_get_min_max_order('bet_events', 'MIN', 'event_id', $bet_event['event_id']);
        
        if ($min_order != $current_order) {          
            
            $lower_order_bet_event = betpress_get_lower_order($current_order, 'bet_events', 'event_id', $bet_event['event_id']);
            $lower_order = $lower_order_bet_event['bet_event_sort_order'];
            betpress_update('bet_events', array('bet_event_sort_order' => $lower_order), array('bet_event_id' => $bet_event['bet_event_id']));
            betpress_update('bet_events', array('bet_event_sort_order' => $current_order), array('bet_event_id' => $lower_order_bet_event['bet_event_id']));
            
        }
        
        wp_redirect(betpress_get_url(array('noheader', 'move_up_bet_event')));
        exit();
        
    } else if ( (isset($_GET['move_down_bet_event'])) && ($bet_event = betpress_get_bet_event(betpress_sanitize($_GET['move_down_bet_event']))) 
            && (isset($_GET['noheader'])) && ($_GET['noheader'] === 'true') ) {
        
        
        $current_order = $bet_event['bet_event_sort_order'];
        $max_order = betpress_get_min_max_order('bet_events', 'MAX', 'event_id', $bet_event['event_id']);
        
        if ($max_order != $current_order) {          
            
            $higher_order_bet_event = betpress_get_higher_order($current_order, 'bet_events', 'event_id', $bet_event['event_id']);
            $higher_order = $higher_order_bet_event['bet_event_sort_order'];
            betpress_update('bet_events', array('bet_event_sort_order' => $higher_order), array('bet_event_id' => $bet_event['bet_event_id']));
            betpress_update('bet_events', array('bet_event_sort_order' => $current_order), array('bet_event_id' => $higher_order_bet_event['bet_event_id']));
            
        }
        
        wp_redirect(betpress_get_url(array('noheader', 'move_down_bet_event')));
        exit();
        
    } else if ( (isset($_GET['edit_category'])) && ($category = betpress_get_category(betpress_sanitize($_GET['edit_category'])))
            && (isset($_GET['bet-event']) && ($bet_event = betpress_get_bet_event(betpress_sanitize($_GET['bet-event'])))) ) {
        
        if (isset($_POST['editing_cat'])) {

            $cat_name = betpress_sanitize($_POST['cat_name']);

            $errors = array();

            if (strlen($cat_name) < 1) {

                $errors [] = __('Category name must NOT be empty.', 'BetPress');
            }
            
            if (betpress_is_category_name_exists($cat_name, $bet_event['bet_event_id'], $category['bet_event_cat_id'])) {
                
                $errors [] = __('A category with that name already exists.', 'BetPress');
            }

            if ($errors) {

                foreach ($errors as $error) {

                    $pass['error_message'] = $error;

                    betpress_get_view('error-message', 'admin', $pass);
                }
                
            } else {

                $is_updated = betpress_update(
                        'bet_events_cats',
                        array(
                            'bet_event_cat_name' => $cat_name,
                        ),
                        array(
                            'bet_event_cat_id' => $category['bet_event_cat_id'],
                        )
                );

                if ($is_updated !== false) {
                    
                    betpress_register_string_for_translation('cat-' . $cat_name, $cat_name);

                    $pass['update_message'] = __('Category edited.', 'BetPress');
                    betpress_get_view('updated-message', 'admin', $pass);
                } else {

                    $pass['error_message'] = __('Database error.', 'BetPress');
                    betpress_get_view('error-message', 'admin', $pass);
                }
            }
        }
        
        
        $pass['back_url'] = betpress_get_url(array('edit_category'));
        $pass['category'] = betpress_get_category(betpress_sanitize($_GET['edit_category']));
        betpress_get_view('edit-category', 'admin', $pass);
        
    } else if ( (isset($_GET['delete_category'])) && ($category = betpress_get_category(betpress_sanitize($_GET['delete_category']))) 
            && (isset($_GET['noheader'])) && ($_GET['noheader'] === 'true') ) {
        
        $delete_cat = betpress_delete('bet_events_cats', array('bet_event_cat_id' => (int)$category['bet_event_cat_id']));
        
        if ($delete_cat) {
        
            $deleted_bet_options_ids = array();

            $bet_options_to_delete = betpress_get_bet_options($category['bet_event_cat_id']);
            foreach ($bet_options_to_delete as $bet_option) {

                $deleted_bet_options_ids [] = $bet_option['bet_option_id'];
            }
            
            betpress_delete_bet_options_from_unsubmitted_slips($deleted_bet_options_ids);

            betpress_delete('bet_options', array('bet_event_cat_id' => (int)$category['bet_event_cat_id']));
            
        }
        
        wp_redirect(betpress_get_url(array('noheader', 'delete_category')));
        exit();
        
    } else if ( (isset($_GET['move_down_cat'])) && ($category = betpress_get_category(betpress_sanitize($_GET['move_down_cat']))) 
            && (isset($_GET['noheader'])) && ($_GET['noheader'] === 'true') ) {
        
        
        $current_order = $category['bet_event_cat_sort_order'];
        $max_order = betpress_get_min_max_order('bet_events_cats', 'MAX', 'bet_event_id', $category['bet_event_id'], 'bet_event_cat');
        
        if ($max_order != $current_order) {          
            
            $higher_order_bet_event_cat = betpress_get_higher_order($current_order, 'bet_events_cats', 'bet_event_id', $category['bet_event_id'], 'bet_event_cat');
            $higher_order = $higher_order_bet_event_cat['bet_event_cat_sort_order'];
            betpress_update('bet_events_cats', array('bet_event_cat_sort_order' => $higher_order), array('bet_event_cat_id' => $category['bet_event_cat_id']));
            betpress_update('bet_events_cats', array('bet_event_cat_sort_order' => $current_order), array('bet_event_cat_id' => $higher_order_bet_event_cat['bet_event_cat_id']));
            
        }
        
        wp_redirect(betpress_get_url(array('noheader', 'move_down_cat')));
        exit();
        
    } else if ( (isset($_GET['move_up_cat'])) && ($category = betpress_get_category(betpress_sanitize($_GET['move_up_cat']))) 
            && (isset($_GET['noheader'])) && ($_GET['noheader'] === 'true') ) {
        
        
        $current_order = $category['bet_event_cat_sort_order'];
        $min_order = betpress_get_min_max_order('bet_events_cats', 'MIN', 'bet_event_id', $category['bet_event_id'], 'bet_event_cat');
        
        if ($min_order != $current_order) {          
            
            $lower_order_bet_event_cat = betpress_get_lower_order($current_order, 'bet_events_cats', 'bet_event_id', $category['bet_event_id'], 'bet_event_cat');
            $lower_order = $lower_order_bet_event_cat['bet_event_cat_sort_order'];
            betpress_update('bet_events_cats', array('bet_event_cat_sort_order' => $lower_order), array('bet_event_cat_id' => $category['bet_event_cat_id']));
            betpress_update('bet_events_cats', array('bet_event_cat_sort_order' => $current_order), array('bet_event_cat_id' => $lower_order_bet_event_cat['bet_event_cat_id']));
            
        }
        
        wp_redirect(betpress_get_url(array('noheader', 'move_up_cat')));
        exit();
        
    } else if ( (isset($_GET['edit_bet_option'])) && ($bet_option = betpress_get_bet_option(betpress_sanitize($_GET['edit_bet_option'])))
            && (isset($_GET['bet-event'])) && ($bet_event = betpress_get_bet_event(betpress_sanitize($_GET['bet-event'])))
            && (betpress_is_bet_option_in_bet_event($bet_option['bet_option_id'], $bet_event['bet_event_id'])) ) {
        
        if (isset($_POST['editing_bet_option'])) {

            $bet_option_name = betpress_sanitize($_POST['bet_option_name']);
            
            $bet_option_odd = betpress_floordec(betpress_sanitize($_POST['bet_option_odd']));
            
            $bet_option_status = betpress_sanitize($_POST['status']);

            $errors = array();

            if (strlen($bet_option_name) < 1) {

                $errors [] = __('Bet option name must NOT be empty.', 'BetPress');
            }
            
            if ($bet_option_odd < 1) {
                
                $errors [] = __('Odd can\'t be less than 1.', 'BetPress');
            }
            
            if ( ! betpress_is_status_exists($bet_option_status, 'bet_option') ) {
                
                $errors [] = __('No such status.', 'BetPress');
            }

            if ($errors) {

                foreach ($errors as $error) {

                    $pass['error_message'] = $error;

                    betpress_get_view('error-message', 'admin', $pass);
                }
                
            } else {

                $is_updated = betpress_update(
                        'bet_options',
                        array(
                            'bet_option_name' => $bet_option_name,
                            'bet_option_odd' => $bet_option_odd,
                            'status' => $bet_option_status,
                        ),
                        array(
                            'bet_option_id' => $bet_option['bet_option_id'],
                        )
                );

                if ($is_updated !== false) {
                
                    if ($bet_option_status != $bet_option['status']) {
                    
                        switch ($bet_option_status) {

                            case BETPRESS_STATUS_WINNING:

                                if (get_option('bp_one_win_per_cat') === BETPRESS_VALUE_YES) {
                                    betpress_change_bet_option_status(BETPRESS_STATUS_LOSING, $bet_option['bet_event_cat_id'], $bet_option['bet_option_id']);
                                }
                                break;

                            case BETPRESS_STATUS_CANCELED:

                                $sibling_categories = betpress_get_sibling_categories($bet_event['bet_event_id']);
                                foreach ($sibling_categories as $category) {
                                    betpress_change_bet_option_status(BETPRESS_STATUS_CANCELED, $category['bet_event_cat_id']);
                                }
                                break;

                            default:
                                break;
                        }
                        
                        if ( (isset($_POST['check'])) && ('checked' == $_POST['check']) ) {
                            
                            betpress_check_slips();
                            
                        }
                    }
                    
                    betpress_register_string_for_translation('bet-option-' . $bet_option_name, $bet_option_name);
                    betpress_register_string_for_translation('status-' . $bet_option_status, $bet_option_status);

                    $pass['update_message'] = __('Bet option edited.', 'BetPress');
                    betpress_get_view('updated-message', 'admin', $pass);
                } else {

                    $pass['error_message'] = __('Database error.', 'BetPress');
                    betpress_get_view('error-message', 'admin', $pass);
                }
            }
        }
        
        $pass['bet_option'] = betpress_get_bet_option(betpress_sanitize($_GET['edit_bet_option']));
        $pass['categories'] = betpress_get_categories($bet_event['bet_event_id']);
        $pass['statuses'] = array(
            BETPRESS_STATUS_AWAITING => __('awaiting', 'BetPress'),
            BETPRESS_STATUS_WINNING => __('winning', 'BetPress'),
            BETPRESS_STATUS_LOSING => __('losing', 'BetPress'),
            BETPRESS_STATUS_CANCELED => __('canceled', 'BetPress'),
        );
        
        $pass['back_url'] = betpress_get_url(array('edit_bet_option'));
        betpress_get_view('edit-bet-option', 'admin', $pass);
        
    } else if ( (isset($_GET['delete_bet_option'])) && ($bet_option = betpress_get_bet_option(betpress_sanitize($_GET['delete_bet_option']))) 
            && (isset($_GET['noheader'])) && ($_GET['noheader'] === 'true') ) {
        
        betpress_delete('bet_options', array('bet_option_id' => $bet_option['bet_option_id']));
        
        $unsubmitted_slips = betpress_get_unsubmitted_slips();     
        foreach ($unsubmitted_slips as $unsubmitted_slip) {
            
            $slip_bet_options = unserialize($unsubmitted_slip['bet_options_ids']);
            
            if (array_key_exists($bet_option['bet_option_id'], $slip_bet_options)) {
                
                unset($slip_bet_options[$bet_option['bet_option_id']]);
                
            }
            
            betpress_update(
                'slips',
                array('bet_options_ids' => serialize($slip_bet_options)),
                array('slip_id' => $unsubmitted_slip['slip_id'])
            );
            
        }
        
        wp_redirect(betpress_get_url(array('noheader', 'delete_bet_option')));
        exit();
        
    } else if ( (isset($_GET['move_up_bet_option'])) && ($bet_option = betpress_get_bet_option(betpress_sanitize($_GET['move_up_bet_option']))) 
            && (isset($_GET['noheader'])) && ($_GET['noheader'] === 'true') ) {
        
        
        $current_order = $bet_option['bet_option_sort_order'];
        $min_order = betpress_get_min_max_order('bet_options', 'MIN', 'bet_event_cat_id', $bet_option['bet_event_cat_id']);
        
        if ($min_order != $current_order) {          
            
            $lower_order_bet_option = betpress_get_lower_order($current_order, 'bet_options', 'bet_event_cat_id', $bet_option['bet_event_cat_id']);
            $lower_order = $lower_order_bet_option['bet_option_sort_order'];
            betpress_update('bet_options', array('bet_option_sort_order' => $lower_order), array('bet_option_id' => $bet_option['bet_option_id']));
            betpress_update('bet_options', array('bet_option_sort_order' => $current_order), array('bet_option_id' => $lower_order_bet_option['bet_option_id']));
            
        }
        
        wp_redirect(betpress_get_url(array('noheader', 'move_up_bet_option')));
        exit();
        
    } else if ( (isset($_GET['move_down_bet_option'])) && ($bet_option = betpress_get_bet_option(betpress_sanitize($_GET['move_down_bet_option']))) 
            && (isset($_GET['noheader'])) && ($_GET['noheader'] === 'true') ) {
        
        
        $current_order = $bet_option['bet_option_sort_order'];
        $max_order = betpress_get_min_max_order('bet_options', 'MAX', 'bet_event_cat_id', $bet_option['bet_event_cat_id']);
        
        if ($max_order != $current_order) {          
            
            $higher_order_bet_option = betpress_get_higher_order($current_order, 'bet_options', 'bet_event_cat_id', $bet_option['bet_event_cat_id']);
            $higher_order = $higher_order_bet_option['bet_option_sort_order'];
            betpress_update('bet_options', array('bet_option_sort_order' => $higher_order), array('bet_option_id' => $bet_option['bet_option_id']));
            betpress_update('bet_options', array('bet_option_sort_order' => $current_order), array('bet_option_id' => $higher_order_bet_option['bet_option_id']));
            
        }
        
        wp_redirect(betpress_get_url(array('noheader', 'move_down_bet_option')));
        exit();
        
    } elseif ( (isset($_GET['bet-event'])) && (betpress_is_bet_event_exists(betpress_sanitize($_GET['bet-event']))) ) {
        
        $bet_event_ID = (int)betpress_sanitize($_GET['bet-event']);
        
        if (isset($_POST['adding_bet_option'])) {

            $bet_option_name = betpress_sanitize($_POST['bet_option_name']);
            
            $bet_option_odd = betpress_floordec(betpress_sanitize($_POST['bet_option_odd']));

            $category_ID = (int)betpress_sanitize($_POST['category_id']);

            $errors = array();

            if (strlen($bet_option_name) < 1) {

                $errors [] = __('Bet option name must NOT be empty.', 'BetPress');
            }
            
            if ($bet_option_odd < 1) {
                
                $errors [] = __('Odd can\'t be less than 1.', 'BetPress');
            }
            
            if ( ! betpress_is_category_exists($category_ID, $bet_event_ID) ) {
                
                $errors [] = __('No such category.', 'BetPress');
            }

            if ($errors) {

                foreach ($errors as $error) {

                    $pass['error_message'] = $error;

                    betpress_get_view('error-message', 'admin', $pass);
                }
                
            } else {

                $max_order = betpress_get_bet_options_max_order($category_ID);

                $is_inserted = betpress_insert(
                        'bet_options',
                        array(
                            'bet_option_name' => $bet_option_name,
                            'bet_option_odd' => $bet_option_odd,
                            'bet_option_sort_order' => ++$max_order,
                            'bet_event_cat_id' => $category_ID,
                            'status' => BETPRESS_STATUS_AWAITING,
                        )
                );

                if ($is_inserted) {
                    
                    betpress_register_string_for_translation('bet-option-' . $bet_option_name, $bet_option_name);
                    betpress_register_string_for_translation('status-' . BETPRESS_STATUS_AWAITING, BETPRESS_STATUS_AWAITING);

                    $pass['update_message'] = __('Bet option added.', 'BetPress');
                    betpress_get_view('updated-message', 'admin', $pass);
                } else {

                    $pass['error_message'] = __('Database error.', 'BetPress');
                    betpress_get_view('error-message', 'admin', $pass);
                }
            }
        }

        if (isset($_POST['adding_category'])) {

            $category_name = betpress_sanitize($_POST['category_name']);

            $errors = array();

            if (strlen($category_name) < 1) {

                $errors [] = __('Category name must NOT be empty.', 'BetPress');
            }
            
            if (betpress_is_category_name_exists($category_name, $bet_event_ID)) {
                
                $errors [] = __('A category with that name already exists.', 'BetPress');
            }

            if ($errors) {

                foreach ($errors as $error) {

                    $pass['error_message'] = $error;

                    betpress_get_view('error-message', 'admin', $pass);
                }
                
            } else {

                $max_order = betpress_get_cats_max_order($bet_event_ID);

                $is_inserted = betpress_insert(
                        'bet_events_cats',
                        array(
                            'bet_event_cat_name' => $category_name,
                            'bet_event_id' => $bet_event_ID,
                            'bet_event_cat_sort_order' => ++$max_order,
                        )
                );

                if ($is_inserted) {
                    
                    betpress_register_string_for_translation('cat-' . $category_name, $category_name);

                    $pass['update_message'] = __('Category added.', 'BetPress');
                    betpress_get_view('updated-message', 'admin', $pass);
                } else {

                    $pass['error_message'] = __('Database error.', 'BetPress');
                    betpress_get_view('error-message', 'admin', $pass);
                }
            }
        }
        
        $pass['bet_event'] = betpress_get_bet_event($bet_event_ID);
        $pass['categories'] = betpress_get_categories($bet_event_ID);
        
        $bet_options = array();
        
        foreach ($pass['categories'] as $cat) {
            
            $bet_options [] = betpress_get_options($cat['bet_event_cat_id']);
        }
        
        //merge bet options if there are any, otherwise pass empty array cuz the view will foreach
        $pass['bet_options'] = empty($bet_options) ? array() : call_user_func_array('array_merge', $bet_options);
        $pass['back_url'] = betpress_get_url(array('bet-event'));
        betpress_get_view('bet-options', 'admin', $pass);
        betpress_get_view('helper', 'admin');
        
    } else if ( (isset($_GET['event'])) && ($event = betpress_get_event(betpress_sanitize($_GET['event']))) ) {
            
        $event_ID = (int)$event['event_id'];

        if (isset($_POST['adding_bet_event'])) {

            $errors = array();

            $bet_event_name = betpress_sanitize($_POST['bet_event_name']);

            if (strlen($bet_event_name) < 1) {

                $errors [] = __('Bet event name must NOT be empty.', 'BetPress');
            }

            if (betpress_is_bet_event_name_exists($bet_event_name, $event_ID)) {

                $errors [] = __('Bet event already exists, pick another name.', 'BetPress');
            }

            //check is weird but otherwise strtotime will generate an error (at least php doc says so)
            if (( $deadline = strtotime(betpress_sanitize($_POST['deadline'])) ) === false) {

                $errors [] = __('Not a valid date.', 'BetPress');
            } else {

                $valid_date = true;
            }

            if ((isset($valid_date)) && ($deadline < time())) {

                $errors [] = __('Selected date is in the past.', 'BetPress');
            }

            if ($errors) {

                foreach ($errors as $error) {

                    $pass['error_message'] = $error;
                    betpress_get_view('error-message', 'admin', $pass);
                }
            } else {

                $max_order = betpress_get_bet_events_max_order($event_ID);

                $is_inserted = betpress_insert(
                    'bet_events', 
                    array(
                        'bet_event_name' => $bet_event_name,
                        'deadline' => $deadline,
                        'bet_event_sort_order' => ++$max_order,
                        'event_id' => $event_ID,
                    )
                );

                if ($is_inserted) {
                    
                    betpress_register_string_for_translation('bet-event-' . $bet_event_name, $bet_event_name);

                    $pass['update_message'] = __('Bet event added.', 'BetPress');
                    betpress_get_view('updated-message', 'admin', $pass);
                } else {

                    $pass['error_message'] = __('Database error.', 'BetPress');
                    betpress_get_view('error-message', 'admin', $pass);
                }
            }
        }

        $pass['back_url'] = betpress_get_url(array('event'));
        $pass['event'] = betpress_get_event(betpress_sanitize($_GET['event']));
        $pass['bet_events'] = betpress_get_bet_events($event['event_id']);

        //display the view
        betpress_get_view('bet-events', 'admin', $pass);
        betpress_get_view('helper', 'admin');
        
    } else {

        //fetch data to pass to view
        $pass['sports'] = betpress_get_sports();
        $pass['events'] = betpress_get_events();

        betpress_get_view('sports-and-events', 'admin', $pass);
        betpress_get_view('helper', 'admin');
    }
}


