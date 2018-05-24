<?php
//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}
?>
<div class="wrap">
    
    <h2><?php esc_attr_e('Leaderboards', 'BetPress'); ?></h2>
    
    <h3><?php esc_attr_e('Open new leaderboard and close the current active', 'BetPress'); ?></h3>
    
    <form action="<?php echo esc_attr($_SERVER['REQUEST_URI']); ?>" method="POST">
        
        <table class="form-table">
            
            <tr valign="top">
                
                <th scope="row">
                    
                    <label for="leaderboard-name"><?php esc_attr_e('Leaderboard name', 'BetPress'); ?></label>
            
                </th>
                
                <td>
                    
                    <input type="text" id="leaderboard-name" name="leaderboard_name" class="regular-text" />
                    
                </td>
                
            </tr>
            
            <tr valign="top">
                
                <th scope="row">
            
                    <input class="button-primary" type="submit" name="adding_leaderboard" value="<?php esc_attr_e('Open leaderboard', 'BetPress'); ?>" />
            
                </th>
                
                <td class="help-info">
        
                <?php esc_attr_e(''
                        . 'WARNING: You can have ONLY ONE active leaderboard at a time. '
                        . 'Opening new leaderboard will recalculate all slips, '
                        . 'cause reset in all user\'s points and '
                        . 'close the current active leaderboard.', 'BetPress'); ?>
                    
                </td>
                
            </tr>
 
        </table>     

    </form>
    
    <table class="widefat">
        
        <thead>
            
            <tr>
                
                <th class="row-title"><?php esc_attr_e('Name', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Status', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Details', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Actions', 'BetPress'); ?></th>
                
            </tr>
            
        </thead>
        
        <tbody>
            
            <?php foreach ($leaderboards as $lb): ?>
            
            <tr>
                
                <td class="row-title">
                    
                    <?php echo apply_filters('wpml_translate_single_string', $lb['leaderboard_name'], 'BetPress', 'lb-' . $lb['leaderboard_name']); ?>
                    
                </td>
                
                <td>
                    
                    <?php echo apply_filters('wpml_translate_single_string', $lb['leaderboard_status'], 'BetPress', 'status-' . $lb['leaderboard_status']); ?>
                    
                </td>
                
                <td>
                    
                    <a class="button-secondary" href="<?php echo $page_url; ?>&lb=<?php echo $lb['leaderboard_id']; ?>" title="<?php esc_attr_e('See leaderboard', 'BetPress'); ?>">
                    
                        <?php esc_attr_e('See leaderboard', 'BetPress'); ?>
                    
                    </a>
                    
                </td>
                
                <td>
                    
                    <a href="<?php echo $page_url; ?>&edit_lb=<?php echo $lb['leaderboard_id']; ?>" title="<?php esc_attr_e('Edit', 'BetPress'); ?>">
                        
                        <img src="<?php echo BETPRESS_IMAGE_FOLDER . 'edit-16.png'; ?>" alt="<?php esc_attr_e('Edit', 'BetPress'); ?>" />
                    
                    </a>
                    
                </td>
                
            </tr>
            
            <?php endforeach; ?>
            
        </tbody>
        
        <tfoot>
            
            <tr>
                
                <th class="row-title"><?php esc_attr_e('Name', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Status', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Details', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Actions', 'BetPress'); ?></th>
                
            </tr>
            
        </tfoot>
        
    </table>
    
</div>