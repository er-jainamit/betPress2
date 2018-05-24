<?php
//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}
?>
<div class="bet-option-row" style="background-color: <?php echo $subrow_bg; ?>; color: <?php echo $subrow_text; ?>">

    <div class="page-bet-event-name">

        <?php echo apply_filters('wpml_translate_single_string', $bet_option_info['bet_event_name'], 'BetPress', 'bet-event-' . $bet_option_info['bet_event_name']); ?>

    </div>

    <div class="page-bet-cat-name">

        <?php echo apply_filters('wpml_translate_single_string', $bet_option_info['bet_event_cat_name'], 'BetPress', 'cat-' . $bet_option_info['bet_event_cat_name']); ?>

    </div>

    <div class="page-bet-name">

        <?php echo apply_filters('wpml_translate_single_string', $bet_option_info['bet_option_name'], 'BetPress', 'bet-option-' . $bet_option_info['bet_option_name']); ?>

    </div>

    <div class="page-bet-odd">

        <?php echo apply_filters('betpress_odd', $odd_when_submitted); ?>

    </div>

    <div class="page-bet-status">

        <?php echo apply_filters('wpml_translate_single_string', $bet_option_info['status'], 'BetPress', 'status-' . $bet_option_info['status']); ?>

    </div>
    
    <div class="clear"></div>

</div>