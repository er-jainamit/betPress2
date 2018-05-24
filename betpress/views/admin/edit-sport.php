<?php
//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}
?>
<div class="wrap">
    
    <h2>
        <?php printf(
                __('Edit sport %s', 'BetPress'),
                apply_filters('wpml_translate_single_string', $sport['sport_name'], 'BetPress', 'sport-' . $sport['sport_name'])
            ); ?>
    </h2>
    
    <form action="<?php echo esc_attr($_SERVER['REQUEST_URI']); ?>" method="POST">
        
        <table class="form-table">
            
            <tr valign="top">
                
                <th scope="row">
                    
                    <label for="sport-name"><?php esc_attr_e('Sport name', 'BetPress'); ?></label>
            
                </th>
                
                <td>
                    
                    <input type="text" id="sport-name" name="sport_name" class="regular-text" value="<?php echo $sport['sport_name']; ?>" />
                    
                </td>
                
            </tr>
            
            <tr valign="top">
                
                <th scope="row">
            
                    <input class="button-primary" type="submit" name="editing_sport" value="<?php esc_attr_e('Edit sport', 'BetPress'); ?>" />
            
                </th>
                
                <td>
                    
                    <a href="<?php echo $back_url; ?>"><?php esc_attr_e('Go back to sports & events', 'BetPress'); ?></a>
                    
                </td>
                
            </tr>
 
        </table>     

    </form>
    
</div>