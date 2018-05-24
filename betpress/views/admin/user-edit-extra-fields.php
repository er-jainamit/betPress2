<?php
//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}
?>
<h3><?php esc_attr_e('BetPress ', 'BetPress'); ?></h3>

<table class="form-table">
    
    <tr>
        
        <th>
            
            <label for="bp_points"><?php esc_attr_e('BetPress points', 'BetPress'); ?></label>
            
        </th>
        
        <td>
            
            <input type="text" 
                   name="bp_points" 
                   id="bp_points" 
                   value="<?php echo (float) $user_points; ?>" 
                   class="regular-text"
                   <?php if ( ! current_user_can('manage_options') ): echo 'disabled'; endif; ?>
                   />
            
        </td>
        
    </tr>
    
    <tr>
        
        <th>
            
            <label for="bp_points_buyed"><?php esc_attr_e('BetPress bought points', 'BetPress'); ?></label>
            
        </th>
        
        <td>
            
            <input 
                type="text" 
                name="bp_points_buyed"
                id="bp_points_buyed"
                value="<?php echo (int) $user_buyed_points; ?>" 
                class="regular-text" 
                <?php if ( ! current_user_can('manage_options') ): echo 'disabled'; endif; ?>
                />
            
        </td>
        
    </tr>
    
</table>