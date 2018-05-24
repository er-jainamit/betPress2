<?php
//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}
?>
<div class="wrap">
    
    <h2>
        <?php printf(
                __('Edit leaderboard %s', 'BetPress'),
                apply_filters('wpml_translate_single_string', $leaderboard['leaderboard_name'], 'BetPress', 'lb-' . $leaderboard['leaderboard_name'])
            ); ?>
    </h2>
    
    <form action="<?php echo esc_attr($_SERVER['REQUEST_URI']); ?>" method="POST">
        
        <table class="form-table">
            
            <tr valign="top">
                
                <th scope="row">
                    
                    <label for="leaderboard-name"><?php esc_attr_e('Leaderboard name', 'BetPress'); ?></label>
            
                </th>
                
                <td>
                    
                    <input type="text" id="leaderboard-name" name="leaderboard_name" class="regular-text" value="<?php echo esc_attr($leaderboard['leaderboard_name']); ?>" />
                    
                </td>
                
            </tr>
            
            <tr valign="top">
                
                <th scope="row">
            
                    <input class="button-primary" type="submit" name="editing_leaderboard" value="<?php esc_attr_e('Edit leaderboard', 'BetPress'); ?>" />
            
                </th>
                
                <td>
                    
                    <a href="<?php echo $back_url; ?>"><?php esc_attr_e('Go back to leaderboards', 'BetPress'); ?></a>
                    
                </td>
                
            </tr>
 
        </table>     

    </form>
    
</div>