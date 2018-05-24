<?php
//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}
?>
<div class="wrap">
    
    <h2>
        <?php printf(
                __('Bet options for %s', 'BetPress'),
                apply_filters('wpml_translate_single_string', $bet_event['bet_event_name'], 'BetPress', 'bet-event-' . $bet_event['bet_event_name'])
            ); ?>
    </h2>
        
    <h3>
        
        <?php esc_attr_e('Bet options', 'BetPress'); ?>
    
        <a class="page-title-action" id="add-button-bet-option" href="#">
        
            <?php esc_attr_e('Add bet option', 'BetPress'); ?>
        
        </a>
    
    </h3>
    
    <form action="<?php echo esc_attr($_SERVER['REQUEST_URI']); ?>" method="POST" id="add-button-bet-option-target" style="display: none">
        
        <table class="form-table">
            
        <?php if (empty($categories)): ?>
            
            <tr valign="top">
                
                <th scope="row">
                    
                    <div class="help-info"><?php esc_attr_e('Please add a category first.', 'BetPress'); ?></div>
            
                </th>
                
            </tr>
            
        <?php else: ?>
            
            <tr valign="top">
                
                <th scope="row">
                    
                    <label for="bet-option-name"><?php esc_attr_e('Bet option name', 'BetPress'); ?></label>
            
                </th>
                
                <td>
                    
                    <input type="text" id="bet-option-name" name="bet_option_name" class="regular-text" />
                    
                </td>
                
            </tr>
            
            <tr valign="top">
                
                <th scope="row">
                    
                    <label for="bet-option-odd"><?php esc_attr_e('Bet option odd', 'BetPress'); ?></label>
            
                </th>
                
                <td>
                    
                    <input type="number" min="1" step="0.01" id="bet-option-odd" name="bet_option_odd" class="regular-text" />
                    
                </td>
                
            </tr>
            
            <tr valign="top">
                
                <th scope="row">
                    
                    <label for="category-id"><?php esc_attr_e('Apply to category', 'BetPress'); ?></label>
            
                </th>
                
                <td>
                    
                    <select name="category_id" id="category-id">

                    <?php foreach ($categories as $cat): ?>

                        <option value="<?php echo $cat['bet_event_cat_id']; ?>">
                            <?php echo apply_filters('wpml_translate_single_string', $cat['bet_event_cat_name'], 'BetPress', 'cat-' . $cat['bet_event_cat_name']); ?>
                        </option>

                    <?php endforeach; ?>
                    
                    </select>
                    
                </td>
                
            </tr>
            
            <tr valign="top">
                
                <th scope="row">
                    
                    <input class="button-primary" type="submit" name="adding_bet_option" value="<?php esc_attr_e('Add bet option', 'BetPress'); ?>" />
                    
                </th>
                
            </tr>
            
        <?php endif; ?>
 
        </table>

    </form>
    
    <table class="widefat">
        
        <thead>
            
            <tr>
                
                <th class="row-title"><?php esc_attr_e('Bet option name', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Odds', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Status', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Category', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Options', 'BetPress'); ?></th>
                
            </tr>
            
        </thead>
        
        <tbody>
            
            <?php if (empty($bet_options)): ?>
            
            <tr>
                
                <td>
                    
                    <h4><?php esc_attr_e('No bet options added.', 'BetPress'); ?></h4>
                    
                </td>
                
            </tr>
            
            <?php else: ?>
            
                <?php foreach ($bet_options as $bet_option): ?>
            
            <tr>
                
                <td class="row-title">
                    
                    <?php echo apply_filters('wpml_translate_single_string', $bet_option['bet_option_name'], 'BetPress', 'bet-option-' . $bet_option['bet_option_name']); ?>
                    
                </td>
                
                <td>
                    
                    <?php echo $bet_option['bet_option_odd']; ?>
                    
                </td>
                
                <td>
                    
                    <?php echo apply_filters('wpml_translate_single_string', $bet_option['status'], 'BetPress', 'status-' . $bet_option['status']); ?>
                    
                </td>
                
                <td>
                    
                    <?php echo apply_filters('wpml_translate_single_string', $bet_option['bet_event_cat_name'], 'BetPress', 'cat-' . $bet_option['bet_event_cat_name']); ?>
                    
                </td>
                
                <td>
                    
                    <a href="<?php echo $page_url; ?>&edit_bet_option=<?php echo $bet_option['bet_option_id']; ?>">
                    
                        <img src="<?php echo BETPRESS_IMAGE_FOLDER . 'edit-16.png'; ?>" alt="<?php esc_attr_e('Edit', 'BetPress'); ?>" />
                    
                    </a>
                    
                    <a href="<?php echo $page_url; ?>&delete_bet_option=<?php echo $bet_option['bet_option_id']; ?>&noheader=true" class="delete-bet-option">
                    
                       <img src="<?php echo BETPRESS_IMAGE_FOLDER . 'delete-16.png'; ?>" alt="<?php esc_attr_e('Delete', 'BetPress'); ?>" />
                    
                    </a>
                    
                <?php if(betpress_get_min_max_order('bet_options', 'MIN', 'bet_event_cat_id', $bet_option['bet_event_cat_id']) != $bet_option['bet_option_sort_order']): ?>
                    
                    <a href="<?php echo $page_url; ?>&move_up_bet_option=<?php echo $bet_option['bet_option_id']; ?>&noheader=true">
                        
                        <img src="<?php echo BETPRESS_IMAGE_FOLDER . 'up-arrow-16.png'; ?>" alt="<?php esc_attr_e('Move up', 'BetPress'); ?>" />
                    
                    </a>
                    
                <?php endif; ?>
                    
                    
                <?php if(betpress_get_min_max_order('bet_options', 'MAX', 'bet_event_cat_id', $bet_option['bet_event_cat_id']) != $bet_option['bet_option_sort_order']): ?>
                    
                    <a href="<?php echo $page_url; ?>&move_down_bet_option=<?php echo $bet_option['bet_option_id']; ?>&noheader=true">
                        
                        <img src="<?php echo BETPRESS_IMAGE_FOLDER . 'down-arrow-16.png'; ?>" alt="<?php esc_attr_e('Move down', 'BetPress'); ?>" />
                    
                    </a>
                    
                <?php endif; ?>
                    
                </td>
                
            </tr>
            
                <?php endforeach; ?>
            
            <?php endif; ?>
            
        </tbody>
        
        <tfoot>
            
            <tr>
                
                <th class="row-title"><?php esc_attr_e('Bet option name', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Odds', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Status', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Category', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Options', 'BetPress'); ?></th>
                
            </tr>
            
        </tfoot>
        
    </table>
    
    <h3>
        
        <?php esc_attr_e('Categories', 'BetPress') ?>
    
        <a class="page-title-action" id="add-button-category" href="#">
        
            <?php esc_attr_e('Add category', 'BetPress'); ?>
        
        </a>
        
    </h3>
    
    <form action="<?php echo esc_attr($_SERVER['REQUEST_URI']); ?>" method="POST" id="add-button-category-target" style="display: none">
        
        <table class="form-table">
            
            <tr valign="top">
                
                <th scope="row">
                    
                    <label for="category-name"><?php esc_attr_e('Category name', 'BetPress'); ?></label>
            
                </th>
                
                <td>
                    
                    <input type="text" id="category-name" name="category_name" class="regular-text" />
                    
                </td>
                
            </tr>
    
        </table>
        
        <div class="admin-submit">
            
            <input class="button-primary" type="submit" name="adding_category" value="<?php esc_attr_e('Add category', 'BetPress'); ?>" />

        </div>

    </form>
    
    <table class="widefat">
        
        <thead>
            
            <tr>
                
                <th class="row-title"><?php esc_attr_e('Category name', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Options', 'BetPress'); ?></th>
                
            </tr>
            
        </thead>
        
        <tbody>
            
        <?php if (empty($categories)): ?>
            
            <tr>
                
                <td>
                    
                    <h4><?php esc_attr_e('No categories added yet.', 'BetPress'); ?></h4>
                    
                </td>
                
            </tr>
            
        <?php else: ?>
            
            <?php foreach ($categories as $cat): ?>
            
            <tr>
                
                <td class="row-title">
                    
                    <?php echo apply_filters('wpml_translate_single_string', $cat['bet_event_cat_name'], 'BetPress', 'cat-' . $cat['bet_event_cat_name']); ?>
                    
                </td>
                
                <td>
                    
                    <a href="<?php echo $page_url; ?>&edit_category=<?php echo $cat['bet_event_cat_id']; ?>">
                        
                        <img src="<?php echo BETPRESS_IMAGE_FOLDER . 'edit-16.png'; ?>" alt="<?php esc_attr_e('Edit', 'BetPress'); ?>" />
                    
                    </a>
                    
                    <a href="<?php echo $page_url; ?>&delete_category=<?php echo $cat['bet_event_cat_id']; ?>&noheader=true" class="delete-cat">
                        
                        <img src="<?php echo BETPRESS_IMAGE_FOLDER . 'delete-16.png'; ?>" alt="<?php esc_attr_e('Delete', 'BetPress'); ?>" />
                    
                    </a>
                    
                <?php if(betpress_get_min_max_order('bet_events_cats', 'MIN', 'bet_event_id', $cat['bet_event_id'], 'bet_event_cat') != $cat['bet_event_cat_sort_order']): ?>
                    
                    <a href="<?php echo $page_url; ?>&move_up_cat=<?php echo $cat['bet_event_cat_id']; ?>&noheader=true">
                        
                        <img src="<?php echo BETPRESS_IMAGE_FOLDER . 'up-arrow-16.png'; ?>" alt="<?php esc_attr_e('Move up', 'BetPress'); ?>" />
                    
                    </a>
                    
                <?php endif; ?>
                    
                    
                <?php if(betpress_get_min_max_order('bet_events_cats', 'MAX', 'bet_event_id', $cat['bet_event_id'], 'bet_event_cat') != $cat['bet_event_cat_sort_order']): ?>
                    
                    <a href="<?php echo $page_url; ?>&move_down_cat=<?php echo $cat['bet_event_cat_id']; ?>&noheader=true">
                        
                        <img src="<?php echo BETPRESS_IMAGE_FOLDER . 'down-arrow-16.png'; ?>" alt="<?php esc_attr_e('Move down', 'BetPress'); ?>" />
                    
                    </a>
                    
                <?php endif; ?>
                    
                </td>
                
            </tr>
            
            <?php endforeach; ?>
            
        <?php endif; ?>
            
        </tbody>
        
        <tfoot>
            
            <tr>
                
                <th class="row-title"><?php esc_attr_e('Category name', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Options', 'BetPress'); ?></th>
                
            </tr>
            
        </tfoot>
        
    </table>
    
    <div class="help-info">
        
        <a href="<?php echo $back_url; ?>"><?php esc_attr_e('Go back to bet events.', 'BetPress'); ?></a>
        
    </div>
 
</div>