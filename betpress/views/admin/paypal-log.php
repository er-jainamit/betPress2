<?php
//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}
?>
<div class="wrap">
    
    <h2><?php esc_attr_e('PayPal log', 'BetPress'); ?></h2>
    
    <form action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="GET">
        
        <div style="margin-bottom: 40px;"><h4><?php esc_attr_e('This page is useful only in the full version of BetPress.', 'BetPress'); ?></h4></div>
        
        <input type="hidden" name="page" value="bp-paypal" />
    
        <select name="user_id">
            
            <option value="0" selected><?php esc_attr_e('All users', 'BetPress'); ?></option>
            
            <?php foreach ($users as $user): ?>
            
            <option value="<?php echo $user['user_id']; ?>" <?php echo ( isset($_GET['user_id']) && $_GET['user_id'] == $user['user_id'] ) ? 'selected' : '' ?>>
                
                <?php echo $user['display_name']; ?>
                
            </option>
            
            <?php endforeach; ?>
            
        </select>
        
        <input type="submit" class="button-secondary" value="<?php esc_attr_e('Filter', 'BetPress'); ?>" />
    
    </form>
    
    <table class="widefat">
        
        <thead>
            
            <tr>
                
                <th class="row-title"><?php esc_attr_e('Nickname', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Status', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Date*', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('IP address', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Points', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Message', 'BetPress'); ?></th>
                
            </tr>
            
        </thead>
        
        <tbody>
            
            <?php if (empty($logs)): ?>
            
            <tr>
                
                <td>
                    
                    <h4><?php esc_attr_e('No transactions yet.', 'BetPress'); ?></h4>
                    
                </td>
                
            </tr>
            
            <?php else: ?>
            
                <?php foreach ($logs as $log): ?>
            
            <tr>
                
                <td class="row-title">
                    
                    <?php echo $log['display_name']; ?>
                    
                </td>
                
                <td>
                    
                    <span class="<?php echo strcmp($log['transaction_status'], BETPRESS_STATUS_FAIL) === 0 ? 'inactive' : 'active' ;?>">
                        <?php echo $log['transaction_status']; ?>
                    </span>
                    
                </td>
                
                <td>
                    
                    <?php echo betpress_local_tz_time($log['transaction_time']); ?>
                    
                </td>
                
                <td>
                    
                    <?php echo $log['user_ip']; ?>
                    
                </td>
                
                <td>
                    
                    <?php echo $log['points']; ?>
                    
                </td>
                
                <td>
                    
                    <?php echo $log['transaction_message']; ?>
                    
                </td>
                
            </tr>
            
                <?php endforeach; ?>
            
            <?php endif; ?>
            
        </tbody>
        
        <tfoot>
            
            <tr>
                
                <th class="row-title"><?php esc_attr_e('Nickname', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Status', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Date*', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('IP address', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Points', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Message', 'BetPress'); ?></th>
                
            </tr>
            
        </tfoot>
        
    </table>
    
    <div class="help-info">
        
        <?php esc_attr_e('*Time is showed in the timezone you have selected via Settings->General page.', 'BetPress'); ?>
        
    </div>
 
</div>

