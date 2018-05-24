<?php

//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}

class BetPress_betslip extends WP_Widget {
    
    public function __construct() {
        
        $options = array(
            'name' => __('BetPress Slip', 'BetPress'),
        );
        
        parent::__construct('betpress_betslip', 'BetPress Slip', $options);
    }
    
    public function form ($data) {
        
        ?>

        <p>
            
            <label for="<?php echo $this->get_field_id('title');?>">
                
                <?php esc_attr_e('Title', 'BetPress') ?>
            
            </label>
            
            <input 
                class="widefat"
                type="text"
                id="<?php echo $this->get_field_id('title');?>"
                name="<?php echo $this->get_field_name('title'); ?>"
                value="<?php echo isset($data['title']) ? $data['title'] : ''; ?>"
            />
            
        </p>
        
        <p>
            
            <input 
                class="checkbox"
                type="checkbox"
                <?php if (isset($data['show_points'])) { checked($data['show_points'], BETPRESS_VALUE_ON); } ?>
                id="<?php echo $this->get_field_id('show_points'); ?>"
                name="<?php echo $this->get_field_name('show_points'); ?>" 
                />
            
            <label for="<?php echo $this->get_field_id('show_points'); ?>">
                
                <?php esc_attr_e('Show points?', 'BetPress'); ?>
                
            </label>
            
        </p>
    
       <?php 
    }
    
    public function update($new_instance, $old_instance) {
        
	$instance = $old_instance;
        $instance['show_points'] = $new_instance['show_points'];
        $instance['title'] = ( ! empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';

	return $instance;
    }
    
    public function widget ($arguments, $data) {
        
        global $is_betslip_showed;
        
        //restrict the widget from showing more than once
        if (true === $is_betslip_showed) {
            return;
        }
        
        $is_betslip_showed = true;
        
        extract($arguments);
        extract($data);
        
        $title = apply_filters('widget_title', $title);
        
        echo $before_widget;
        echo $before_title . $title . $after_title;

        $user_ID = get_current_user_id();

        $unsubmitted_slip = betpress_get_user_unsubmitted_slip($user_ID);
        
        $pass['bet_options'] = array();

        if ($unsubmitted_slip) {

            $serialized_bet_options = $unsubmitted_slip['bet_options_ids'];

            $unserialized_bet_options = unserialize($serialized_bet_options);
            
            foreach ($unserialized_bet_options as $bet_option_ID => $bet_option_odd) {
                
                $pass['bet_options'] [] = betpress_get_bet_option($bet_option_ID);
                
            }
            
        }
        
        $user_db_points = get_user_meta($user_ID, 'bp_points', true);
        
        $pass['user_points'] = ('' === $user_db_points) ? get_option('bp_starting_points') : $user_db_points;
        $pass['show_points'] = ($data['show_points'] === BETPRESS_VALUE_ON) ? true : false;
        betpress_get_view('betslip', 'widgets', $pass);
        
        echo $after_widget;
    }
}

add_action('widgets_init', 'betpress_register_betslip_widget');

function betpress_register_betslip_widget () {
    
    register_widget('BetPress_betslip');
}