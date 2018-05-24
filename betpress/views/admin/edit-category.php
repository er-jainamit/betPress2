<?php
//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}
?>
<div class="wrap">
    
    <h2>
        <?php printf(
                __('Edit category %s', 'BetPress'),
                apply_filters('wpml_translate_single_string', $category['bet_event_cat_name'], 'BetPress', 'cat-' . $category['bet_event_cat_name'])
            ); ?>
    </h2>
    
    <form action="<?php echo esc_attr($_SERVER['REQUEST_URI']); ?>" method="POST">
        
        <table class="form-table">
            
            <tr valign="top">
                
                <th scope="row">
                    
                    <label for="cat-name"><?php esc_attr_e('Category name', 'BetPress'); ?></label>
            
                </th>
                
                <td>
                    
                    <input type="text" id="cat-name" name="cat_name" class="regular-text" value="<?php echo $category['bet_event_cat_name']; ?>" />
                    
                </td>
                
            </tr>
            
            <tr valign="top">
                
                <th scope="row">
            
                    <input class="button-primary" type="submit" name="editing_cat" value="<?php esc_attr_e('Edit category', 'BetPress'); ?>" />
            
                </th>
                
                <td>
                    
                    <a href="<?php echo $back_url; ?>"><?php esc_attr_e('Go back to bet options', 'BetPress'); ?></a>
                    
                </td>
                
            </tr>
 
        </table>     

    </form>
    
</div>