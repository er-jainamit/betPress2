<?php
//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}
?>
<div class="bet-option-slip-wrapper">

    <div class="slip-bet-event-name">

        <?php echo apply_filters('wpml_translate_single_string', $bet_option_info['bet_event_name'], 'BetPress', 'bet-event-' . $bet_option_info['bet_event_name']); ?>

    </div>

    <div class="slip-delete-option">
        
        <a href="#" id="delete-<?php echo $bet_option_info['bet_option_id']; ?>" class="delete-bet-option">
        
            <img src="<?php echo BETPRESS_IMAGE_FOLDER . 'delete-16.png'; ?>" alt="<?php esc_attr_e('Delete', 'BetPress'); ?>" />
        
        </a>
        
    </div>
    
    <div class="clear"></div>

    <div class="slip-bet-cat-name">

        <?php echo apply_filters('wpml_translate_single_string', $bet_option_info['bet_event_cat_name'], 'BetPress', 'cat-' . $bet_option_info['bet_event_cat_name']); ?>

    </div>

    <div class="slip-bet-odd">
        
        <?php esc_attr_e('Odd: ', 'BetPress'); ?>

        <?php echo apply_filters('betpress_odd', $bet_option_info['bet_option_odd']); ?>

    </div>

    <div class="slip-bet-name">

        <?php echo apply_filters('wpml_translate_single_string', $bet_option_info['bet_option_name'], 'BetPress', 'bet-option-' . $bet_option_info['bet_option_name']); ?>

    </div>
    
    <div class="clear"></div>

</div>
