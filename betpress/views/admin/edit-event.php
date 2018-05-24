<?php
//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}
?>
<div class="wrap">
    
    <h2>
        <?php printf(
                __('Edit event %s', 'BetPress'),
                apply_filters('wpml_translate_single_string', $event['event_name'], 'BetPress', 'event-' . $event['event_name'])
            ); ?>
    </h2>
    
    <form action="<?php echo esc_attr($_SERVER['REQUEST_URI']); ?>" method="POST">
        
        <table class="form-table">
            
            <tr valign="top">
                
                <th scope="row">
                    
                    <label for="event-name"><?php esc_attr_e('Event name', 'BetPress'); ?></label>
            
                </th>
                
                <td>
                    
                    <input type="text" id="event-name" name="event_name" class="regular-text" value="<?php echo $event['event_name']; ?>" />
                    
                </td>
                
            </tr>
            
            <tr valign="top">
                
                <th scope="row">
                    
                    <label for="sport-id"><?php esc_attr_e('Apply to sport', 'BetPress'); ?></label>
            
                </th>
                
                <td>
                    
                    <select name="sport_id" id="sport-id">

                    <?php foreach ($sports as $sport): ?>

                        <option value="<?php echo $sport['sport_id']; ?>" <?php if ($sport['sport_id'] == $event['sport_id']): echo 'selected'; endif; ?>>
                            
                            <?php echo apply_filters('wpml_translate_single_string', $sport['sport_name'], 'BetPress', 'sport-' . $sport['sport_name']); ?>
                            
                        </option>

                    <?php endforeach; ?>
                    
                    </select>
                    
                </td>
                
            </tr>
            
            <tr valign="top">
                
                <th scope="row">
            
                    <input class="button-primary" type="submit" name="editing_event" value="<?php esc_attr_e('Edit event', 'BetPress'); ?>" />
            
                </th>
                
                <td>
                    
                    <a href="<?php echo $back_url; ?>"><?php esc_attr_e('Go back to sports & events', 'BetPress'); ?></a>
                    
                </td>
                
            </tr>
 
        </table>     

    </form>
    
</div>