<?php
//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}
?>
<div class="wrap">
    
    <h2>
        <?php printf(
                __('Edit bet option %s', 'BetPress'),
                apply_filters('wpml_translate_single_string', $bet_option['bet_option_name'], 'BetPress', 'bet-option-' . $bet_option['bet_option_name'])
            ); ?>
    </h2>
    
    <form action="<?php echo esc_attr($_SERVER['REQUEST_URI']); ?>" method="POST">
        
        <table class="form-table">
            
            <tr valign="top">
                
                <th scope="row">
                    
                    <label for="bet-option-name"><?php esc_attr_e('Bet option name', 'BetPress'); ?></label>
            
                </th>
                
                <td>
                    
                    <input type="text" id="bet-option-name" name="bet_option_name" class="regular-text" value="<?php echo $bet_option['bet_option_name']; ?>" />
                    
                </td>
                
            </tr>
            
            <tr valign="top">
                
                <th scope="row">
                    
                    <label for="bet-option-odd"><?php esc_attr_e('Bet option odd', 'BetPress'); ?></label>
            
                </th>
                
                <td>
                    
                    <input type="number" min="1" step="0.01" id="bet-option-odd" name="bet_option_odd" class="regular-text" value="<?php echo $bet_option['bet_option_odd']; ?>" />
                    
                </td>
                
            </tr>
            
            <tr valign="top">
                
                <th scope="row">
                    
                    <label for="edit-bet-option-status"><?php esc_attr_e('Status', 'BetPress'); ?></label>
            
                </th>
                
                <td>
                    
                    <select name="status" id="edit-bet-option-status">

                    <?php foreach ($statuses as $constant => $translated_status): ?>

                        <option value="<?php echo $constant; ?>" <?php echo $constant == $bet_option['status'] ? 'selected' : ''; ?>>
                            
                            <?php echo $translated_status; ?>
                        
                        </option>

                    <?php endforeach; ?>
                    
                    </select>
                    
                </td>
                
            </tr>
            
            <?php if (BETPRESS_STATUS_AWAITING === $bet_option['status']): ?>
            
            <tr valign="top">
                
                <th scope="row">
                    
                    <label for="check-awaiting-slips"><?php esc_attr_e('Update the awaiting slips?', 'BetPress'); ?></label>
            
                </th>
                
                <td>
                    
                    <input type="checkbox" name="check" id="check-awaiting-slips" value="checked" />
                    
                </td>
                
            </tr>
            
            <?php endif; ?>
            
            <tr valign="top">
                
                <th scope="row">
                    
                    <input class="button-primary" type="submit" name="editing_bet_option" value="<?php esc_attr_e('Edit bet option', 'BetPress'); ?>" />
                    
                </th>
                
                <td>
                    
                    <a href="<?php echo $back_url; ?>"><?php esc_attr_e('Go back to bet options', 'BetPress'); ?></a>
                    
                </td>
                
            </tr>
 
        </table>     

    </form>
    
</div>