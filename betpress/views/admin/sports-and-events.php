<?php
//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}
?>
<div class="wrap">
    
    <h2><?php esc_attr_e('Sports & Events', 'BetPress');?></h2>
        
    <h3>
        
        <?php esc_attr_e('Events', 'BetPress'); ?>
    
        <a class="page-title-action" id="add-button-event" href="#">
        
            <?php esc_attr_e('Add event', 'BetPress'); ?>
        
        </a>
        
    </h3>
    
    <form action="<?php echo esc_attr($_SERVER['REQUEST_URI']); ?>" method="POST" id="add-button-event-target" style="display: none">
        
        <table class="form-table">
            
            <?php if ($sports): ?>
            
            <tr valign="top">
                
                <th scope="row">
                    
                    <label for="event-name"><?php esc_attr_e('Event name', 'BetPress'); ?></label>
            
                </th>
                
                <td>
                    
                    <input type="text" id="event-name" name="event_name" class="regular-text" />
                    
                </td>
                
            </tr>
            
            <tr valign="top">
                
                <th scope="row">
                    
                    <label for="sport-id"><?php esc_attr_e('Apply to sport', 'BetPress'); ?></label>
            
                </th>
                
                <td>
                    
                    <select name="sport_id" id="sport-id">

                    <?php foreach ($sports as $sport): ?>

                        <option value="<?php echo $sport['sport_id']; ?>">
                            <?php echo apply_filters('wpml_translate_single_string', $sport['sport_name'], 'BetPress', 'sport-' . $sport['sport_name']); ?>
                        </option>

                    <?php endforeach; ?>
                    
                    </select>
                    
                </td>
                
            </tr>
            
            <tr valign="top">
                
                <th scope="row">
                    
                    <input class="button-primary" type="submit" name="adding_event" value="<?php esc_attr_e('Add event', 'BetPress'); ?>" />
            
                </th>
                
            </tr>
            
            <?php else: ?>
            
            <tr><td><div class="help-info"><?php esc_attr_e('Please add a sport first.', 'BetPress'); ?></div></td></tr>
            
            <?php endif; ?>
 
        </table>

    </form>
    
    <table class="widefat">
        
        <thead>
            
            <tr>
                
                <th class="row-title"><?php esc_attr_e('Event name', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Sport', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Manage', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Actions', 'BetPress'); ?></th>
                
            </tr>
            
        </thead>
        
        <tbody>
            
            <?php if ($events): ?>
            
            <?php foreach ($events as $event): ?>
            
            <tr>
                
                <td class="row-title">
                    
                    <?php echo apply_filters('wpml_translate_single_string', $event['event_name'], 'BetPress', 'event-' . $event['event_name']); ?>
                    
                </td>
                
                <td>
                    
                    <?php echo apply_filters('wpml_translate_single_string', $event['sport_name'], 'BetPress', 'sport-' . $event['sport_name']); ?>
                    
                </td>
                
                <td>
                    
                    <a class="button-secondary" href="<?php echo $page_url; ?>&event=<?php echo $event['event_id']; ?>" title="<?php esc_attr_e('Edit', 'BetPress'); ?>">
                    
                        <?php esc_attr_e('Manage event', 'BetPress'); ?>
                    
                    </a>
                    
                </td>
                
                <td>
                    
                    <a href="<?php echo $page_url; ?>&edit_event=<?php echo $event['event_id']; ?>" title="<?php esc_attr_e('Edit', 'BetPress'); ?>">
                        
                        <img src="<?php echo BETPRESS_IMAGE_FOLDER . 'edit-16.png'; ?>" alt="<?php esc_attr_e('Edit', 'BetPress'); ?>" />
                    
                    </a>
                    
                    <a href="<?php echo $page_url; ?>&delete_event=<?php echo $event['event_id']; ?>&noheader=true" title="<?php esc_attr_e('Delete', 'BetPress'); ?>" class="delete-event">
                        
                        <img src="<?php echo BETPRESS_IMAGE_FOLDER . 'delete-16.png'; ?>" alt="<?php esc_attr_e('Delete', 'BetPress'); ?>" />
                    
                    </a>
                    
                    <?php if(betpress_get_min_max_order('events', 'MIN', 'sport_id', $event['sport_id']) != $event['event_sort_order']): ?>
                    
                    <a href="<?php echo $page_url; ?>&move_up_event=<?php echo $event['event_id']; ?>&noheader=true" title="<?php esc_attr_e('Move up', 'BetPress'); ?>">
                        
                        <img src="<?php echo BETPRESS_IMAGE_FOLDER . 'up-arrow-16.png'; ?>" alt="<?php esc_attr_e('Move up', 'BetPress'); ?>" />
                    
                    </a>
                    
                    <?php endif; ?>
                    
                    <?php if(betpress_get_min_max_order('events', 'MAX', 'sport_id', $event['sport_id']) != $event['event_sort_order']): ?>
                    
                    <a href="<?php echo $page_url; ?>&move_down_event=<?php echo $event['event_id']; ?>&noheader=true" title="<?php esc_attr_e('Move down', 'BetPress'); ?>">
                        
                        <img src="<?php echo BETPRESS_IMAGE_FOLDER . 'down-arrow-16.png'; ?>" alt="<?php esc_attr_e('Move down', 'BetPress'); ?>" />
                    
                    </a>
                    
                    <?php endif; ?>
                    
                </td>
                
            </tr>
            
            <?php endforeach; ?>
            
            <?php else: ?>
            
            <tr><td><h4><?php esc_attr_e('No events added yet.', 'BetPress'); ?></h4></td></tr>
            
            <?php endif; ?>
            
        </tbody>
        
        <tfoot>
            
            <tr>
                
                <th class="row-title"><?php esc_attr_e('Event name', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Sport', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Manage', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Actions', 'BetPress'); ?></th>
                
            </tr>
            
        </tfoot>
        
    </table>
    
    <h3>
        
        <?php esc_attr_e('Sports', 'BetPress'); ?>
    
        <a class="page-title-action" id="add-button-sport" href="#">
        
            <?php esc_attr_e('Add sport', 'BetPress'); ?>
        
        </a>
    
    </h3>
    
    <form action="<?php echo esc_attr($_SERVER['REQUEST_URI']); ?>" method="POST" id="add-button-sport-target" style="display: none">
        
        <table class="form-table">
            
            <tr valign="top">
                
                <th scope="row">
                    
                    <label for="sport-name"><?php esc_attr_e('Sport name', 'BetPress'); ?></label>
            
                </th>
                
                <td>
                    
                    <input type="text" id="sport-name" name="sport_name" class="regular-text" />
                    
                </td>
                
            </tr>
            
            <tr valign="top">
                
                <th scope="row">
                    
                    <input class="button-primary" type="submit" name="adding_sport" value="<?php esc_attr_e('Add sport', 'BetPress'); ?>" />
            
                </th>
                
            </tr>
    
        </table>

    </form>
    
    <table class="widefat">
        
        <thead>
            
            <tr>
                
                <th class="row-title"><?php esc_attr_e('Sport name', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Actions', 'BetPress'); ?></th>
                
            </tr>
            
        </thead>
        
        <tbody>
            
    <?php if ($sports): ?>
            
        <?php foreach ($sports as $sport): ?>
            
            <tr>
                
                <td class="row-title">
                    
                    <?php echo apply_filters('wpml_translate_single_string', $sport['sport_name'], 'BetPress', 'sport-' . $sport['sport_name']); ?>
                    
                </td>
                
                <td>
                    
                    <a href="<?php echo $page_url; ?>&edit_sport=<?php echo $sport['sport_id']; ?>" title="<?php esc_attr_e('Edit', 'BetPress'); ?>">
                    
                        <img src="<?php echo BETPRESS_IMAGE_FOLDER . 'edit-16.png'; ?>" alt="<?php esc_attr_e('Edit', 'BetPress'); ?>" />
                        
                    </a>
                    
                    <a href="<?php echo $page_url; ?>&delete_sport=<?php echo $sport['sport_id']; ?>&noheader=true" title="<?php esc_attr_e('Delete', 'BetPress'); ?>" class="delete-sport">
                    
                        <img src="<?php echo BETPRESS_IMAGE_FOLDER . 'delete-16.png'; ?>" alt="<?php esc_attr_e('Delete', 'BetPress'); ?>" />
                    
                    </a>
                    
                <?php if(betpress_get_min_max_order('sports', 'MIN') != $sport['sport_sort_order']): ?>
                    
                    <a href="<?php echo $page_url; ?>&move_up_sport=<?php echo $sport['sport_id']; ?>&noheader=true" title="<?php esc_attr_e('Move up', 'BetPress'); ?>">
                    
                        <img src="<?php echo BETPRESS_IMAGE_FOLDER . 'up-arrow-16.png'; ?>" alt="<?php esc_attr_e('Move up', 'BetPress'); ?>" />
                    
                    </a>
                    
                <?php endif; ?>
                    
                <?php if(betpress_get_min_max_order('sports', 'MAX') != $sport['sport_sort_order']): ?>
                    
                    <a href="<?php echo $page_url; ?>&move_down_sport=<?php echo $sport['sport_id']; ?>&noheader=true" title="<?php esc_attr_e('Move down', 'BetPress'); ?>">
                    
                        <img src="<?php echo BETPRESS_IMAGE_FOLDER . 'down-arrow-16.png'; ?>" alt="<?php esc_attr_e('Move down', 'BetPress'); ?>" />
                                          
                    </a>
                    
                <?php endif; ?>
                    
                </td>
                
            </tr>
            
        <?php endforeach; ?>
            
    <?php else: ?>
            
            <tr><td><h4><?php esc_attr_e('No sports added yet.', 'BetPress'); ?></h4></td></tr>
            
    <?php endif; ?>
            
        </tbody>
        
        <tfoot>
            
            <tr>
                
                <th class="row-title"><?php esc_attr_e('Sport name', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Actions', 'BetPress'); ?></th>
                
            </tr>
            
        </tfoot>
        
    </table>
 
</div>