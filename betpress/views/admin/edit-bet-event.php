<?php
//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}
?>
<div class="wrap">
    
    <h2>
        <?php printf(
                __('Edit bet event %s', 'BetPress'),
                apply_filters('wpml_translate_single_string', $bet_event['bet_event_name'], 'BetPress', 'bet-event-' . $bet_event['bet_event_name'])
            ); ?>
    </h2>
    
    <form action="<?php echo esc_attr($_SERVER['REQUEST_URI']); ?>" method="POST">
        
        <table class="form-table">
            
            <tr valign="top">
                
                <th scope="row">
                    
                    <label for="bet-event-name"><?php esc_attr_e('Bet event name', 'BetPress'); ?></label>
            
                </th>
                
                <td>
                    
                    <input type="text" id="bet-event-name" name="bet_event_name" class="regular-text" value="<?php echo $bet_event['bet_event_name']; ?>" />
                    
                </td>
                
            </tr>
            
            <tr valign="top">
                
                <th scope="row">
                    
                    <label for="deadline"><?php esc_attr_e('Starting date', 'BetPress'); ?></label>
            
                </th>
                
                <td>
                    
                    <input type="text" id="deadline" name="deadline" value="<?php echo betpress_local_tz_time_plus($bet_event['deadline']); ?>" />
                    
                </td>
                
            </tr>
            
            <tr valign="top">
                
                <th scope="row">
            
                    <input class="button-primary" type="submit" name="editing_bet_event" value="<?php esc_attr_e('Edit bet event', 'BetPress'); ?>" />
            
                </th>
                
                <td>
                    
                    <a href="<?php echo $back_url; ?>"><?php esc_attr_e('Go back to bet events', 'BetPress'); ?></a>
                    
                </td>
                
            </tr>
 
        </table>     

    </form>
    
</div>