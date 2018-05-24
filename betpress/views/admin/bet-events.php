<?php
//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}
?>
<div class="wrap">

    <h3>
        <?php
            printf(
                __('Bet events for event %s', 'BetPress'),
                apply_filters('wpml_translate_single_string', $event['event_name'], 'BetPress', 'event-' . $event['event_name'])
            );
        ?>
    
        <a class="page-title-action" id="add-button-bet-event" href="#">
        
            <?php esc_attr_e('Add bet event', 'BetPress'); ?>
        
        </a>
        
    </h3>
    
    <form action="<?php echo esc_attr($_SERVER['REQUEST_URI']); ?>" method="POST" id="add-button-bet-event-target" style="display: none">
        
        <table class="form-table">
            
            <tr valign="top">
                
                <th scope="row">
                    
                    <label for="bet-event-name"><?php esc_attr_e('Bet event name', 'BetPress'); ?></label>
            
                </th>
                
                <td>
                    
                    <input type="text" id="bet-event-name" name="bet_event_name" class="regular-text" />
                    
                </td>
                
            </tr>
            
            <tr valign="top">
                
                <th scope="row">
                    
                    <label for="deadline"><?php esc_attr_e('Starts date', 'BetPress'); ?></label>
            
                </th>
                
                <td>
                    
                    <input type="text" id="deadline" name="deadline" />
                    
                    <i><?php esc_attr_e('Bets will be closed after the starting date.', 'BetPress'); ?></i>
                  
                </td>
                
            </tr>
            
            <tr valign="top">
                
                <th scope="row">
                    
                    <input class="button-primary" type="submit" name="adding_bet_event" value="<?php esc_attr_e('Add bet event', 'BetPress'); ?>" />
            
                </th>
                
            </tr>
 
        </table>

    </form>

    <table class="widefat">

        <thead>

            <tr>

                <th class="row-title"><?php esc_attr_e('Bet event name', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Add/Edit/Remove bet options', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Active?', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Featured?', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Starts date*', 'BetPress'); ?></th>

                <th><?php esc_attr_e('Options', 'BetPress'); ?></th>

            </tr>

        </thead>

        <tbody>
            
        <?php if (empty($bet_events)): ?>
            
            <tr>
                
                <td>
                    
                    <h4><?php esc_attr_e('There are no bet events for this event.', 'BetPress'); ?></h4>
                    
                </td>
                
            </tr>
            
        <?php else: ?>

            <?php foreach ($bet_events as $bet_event): ?>

                <tr>

                    <td class="row-title">

                        <?php echo apply_filters('wpml_translate_single_string', $bet_event['bet_event_name'], 'BetPress', 'bet-event-' . $bet_event['bet_event_name']); ?>

                    </td>
                    
                    <td>
                        
                        <a class="button-secondary" href="<?php echo $page_url . '&bet-event=' . $bet_event['bet_event_id']; ?>">
                        
                            <?php esc_attr_e('Modify bet options', 'BetPress'); ?>
                        
                        </a>
                        
                    </td>
                    
                    <td>
                        
                        <?php if($bet_event['is_active'] == 0): ?>
                        
                        <span class="inactive">
                            
                            <?php esc_attr_e('No, ', 'BetPress'); ?>
                            
                            <a href="<?php echo $page_url; ?>&activate_bet_event=<?php echo $bet_event['bet_event_id']; ?>&noheader=true">
                            
                                <?php esc_attr_e('activate', 'BetPress'); ?>
                            
                            </a>
                               
                        </span>
                        
                        <?php else: ?>
                        
                        <span class="active">
                            
                            <?php esc_attr_e('Yes, ', 'BetPress'); ?>
                            
                            <a href="<?php echo $page_url; ?>&deactivate_bet_event=<?php echo $bet_event['bet_event_id']; ?>&noheader=true">
                            
                                <?php esc_attr_e('deactivate', 'BetPress'); ?>
                            
                            </a>
                               
                        </span>
                        
                        <?php endif; ?>
                        
                    </td>
                    
                    <td>
                        
                        <?php if($bet_event['is_featured'] == 0): ?>
                        
                        <span class="inactive">
                            
                            <?php esc_attr_e('Off, ', 'BetPress'); ?>
                            
                            <a href="<?php echo $page_url; ?>&feature_on_bet_event=<?php echo $bet_event['bet_event_id']; ?>&noheader=true">
                            
                                <?php esc_attr_e('switch on', 'BetPress'); ?>
                            
                            </a>
                               
                        </span>
                        
                        <?php else: ?>
                        
                        <span class="active">
                            
                            <?php esc_attr_e('On, ', 'BetPress'); ?>
                            
                            <a href="<?php echo $page_url; ?>&feature_off_bet_event=<?php echo $bet_event['bet_event_id']; ?>&noheader=true">
                            
                                <?php esc_attr_e('switch off', 'BetPress'); ?>
                            
                            </a>
                               
                        </span>
                        
                        <?php endif; ?>
                        
                    </td>
                    
                    <td>
                        
                        <?php echo betpress_local_tz_time($bet_event['deadline']); ?>
                        
                    </td>

                    <td>
                        
                        <a href="<?php echo $page_url; ?>&edit_bet_event=<?php echo $bet_event['bet_event_id']; ?>" title="<?php esc_attr_e('Edit', 'BetPress'); ?>">
                            
                            <img src="<?php echo BETPRESS_IMAGE_FOLDER . 'edit-16.png'; ?>" alt="<?php esc_attr_e('Edit', 'BetPress'); ?>" />
                            
                        </a>

                        <a href="<?php echo $page_url; ?>&delete_bet_event=<?php echo $bet_event['bet_event_id']; ?>&noheader=true" title="<?php esc_attr_e('Delete', 'BetPress'); ?>" class="delete-bet-event">
                            
                            <img src="<?php echo BETPRESS_IMAGE_FOLDER . 'delete-16.png'; ?>" alt="<?php esc_attr_e('Delete', 'BetPress'); ?>" />
                            
                        </a>
                        
                    <?php if(betpress_get_min_max_order('bet_events', 'MIN', 'event_id', $bet_event['event_id']) != $bet_event['bet_event_sort_order']): ?>
                    
                        <a href="<?php echo $page_url; ?>&move_up_bet_event=<?php echo $bet_event['bet_event_id']; ?>&noheader=true" title="<?php esc_attr_e('Move up', 'BetPress'); ?>">
                        
                            <img src="<?php echo BETPRESS_IMAGE_FOLDER . 'up-arrow-16.png'; ?>" alt="<?php esc_attr_e('Move up', 'BetPress'); ?>" />
                    
                        </a>
                    
                    <?php endif; ?>
                    
                    <?php if(betpress_get_min_max_order('bet_events', 'MAX', 'event_id', $bet_event['event_id']) != $bet_event['bet_event_sort_order']): ?>
                    
                        <a href="<?php echo $page_url; ?>&move_down_bet_event=<?php echo $bet_event['bet_event_id']; ?>&noheader=true" title="<?php esc_attr_e('Move down', 'BetPress'); ?>">
                        
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

                <th class="row-title"><?php esc_attr_e('Bet event name', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Add/Edit/Remove bet options', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Active?', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Featured?', 'BetPress'); ?></th>
                
                <th><?php esc_attr_e('Starts date*', 'BetPress'); ?></th>

                <th><?php esc_attr_e('Options', 'BetPress'); ?></th>

            </tr>

        </tfoot>

    </table>
    
    <div class="help-info">
        
        <?php esc_attr_e('*Time is showed in the timezone you have selected via Settings->General page.', 'BetPress'); ?>
        
    </div>
    
    <div class="help-info">
        
        <a href="<?php echo $back_url; ?>"><?php esc_attr_e('Go back to sports and events.', 'BetPress'); ?></a>
        
    </div>

</div>