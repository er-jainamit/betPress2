<?php
//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}
?>

<?php if ($active_bettings) : ?>

<div class="bettings-wrapper">

    <?php foreach ($sports as $sport): ?>
    
        <?php if ($sport['count_active_events'] > 0): ?>

        <div class="sport-wrapper">

            <div class="sport-title-bar" style="background-color: <?php echo $sport_title_bg; ?>; color: <?php echo $sport_title_text; ?>">
                
                <span class="title-text">
                    <?php echo apply_filters('wpml_translate_single_string', $sport['sport_name'], 'BetPress', 'sport-' . $sport['sport_name']); ?>
                </span>
                
            <?php if ($sport['count_active_events'] >= $min_children_to_show_toggle):?>
                
                <span class="toggle-btn" id="sport--<?php echo $sport['sport_id']; ?>"><?php esc_attr_e('-', 'BetPress'); ?></span>
                
            <?php endif; ?>
                
            </div>

            <div class="sport-container" id="sport-container-<?php echo $sport['sport_id']; ?>" style="background-color: <?php echo $sport_container_bg; ?>">

                <?php foreach ($sport['events'] as $event): ?>
                
                    <?php if ($event['count_active_bet_events'] > 0): ?>

                    <div class="event-wrapper">

                        <div class="event-title-bar" style="background-color: <?php echo $event_title_bg; ?>; color: <?php echo $event_title_text; ?>">
                            
                            <span class="title-text">
                                <?php echo apply_filters('wpml_translate_single_string', $event['event_name'], 'BetPress', 'event-' . $event['event_name']); ?>
                            </span>
                            
                        <?php if ($event['count_active_bet_events'] >= $min_children_to_show_toggle): ?>
                            
                            <span class="toggle-btn" id="event--<?php echo $event['event_id']; ?>"><?php esc_attr_e('-', 'BetPress'); ?></span>
                            
                        <?php endif; ?>
                            
                        </div>

                        <div class="event-container" id="event-container-<?php echo $event['event_id']; ?>" style="background-color: <?php echo $event_container_bg; ?>">

                            <?php foreach ($event ['bet_events'] as $bet_event): ?>
                            
                                <?php if ( ($bet_event['is_active']) && (count($bet_event['categories']) > 0) ): ?>

                                <div class="bet-event-wrapper">

                                    <div class="bet-event-title-bar" style="background-color: <?php echo $bet_event_title_bg; ?>; color: <?php echo $bet_event_title_text; ?>">
                                        
                                        <span class="title-text">
                                            <?php echo apply_filters('wpml_translate_single_string', $bet_event['bet_event_name'], 'BetPress', 'bet-event-' . $bet_event['bet_event_name']); ?>                                        
                                        </span>
                            
                                    <?php if (count($bet_event['categories']) >= $min_children_to_show_toggle): ?>
                            
                                        <span class="toggle-btn" id="bet-event--<?php echo $bet_event['bet_event_id']; ?>"><?php esc_attr_e('-', 'BetPress'); ?></span>
                            
                                    <?php endif; ?>
                                        
                                    </div>

                                    <div class="bet-event-container" id="bet-event-container-<?php echo $bet_event['bet_event_id']; ?>" style="background-color: <?php echo $bet_event_container_bg; ?>">

                                        <?php foreach ($bet_event ['categories'] as $category): ?>

                                            <div class="cat-wrapper">

                                                <div class="cat-title-bar" style="background-color: <?php echo $cat_title_bg; ?>; color: <?php echo $cat_title_text; ?>">
                                                    <?php echo apply_filters('wpml_translate_single_string', $category['bet_event_cat_name'], 'BetPress', 'cat-' . $category['bet_event_cat_name']); ?>
                                                </div>

                                                <div class="cat-container" style="background-color: <?php echo $cat_container_bg; ?>">

                                                    <?php foreach ($category ['bet_options'] as $bet_option): ?>

                                                        <div class="bet-option-wrapper"
                                                             id="bet-option-btn-<?php echo $bet_option['bet_option_id'] ?>"
                                                             style="width: <?php echo $category['css-width']; ?>%;
                                                                    margin-left: <?php echo $category['css-margin_left']; ?>%;
                                                                    background-color: <?php echo $button_bg; ?>;
                                                                    color: <?php echo $button_text; ?>">

                                                            <div class="bet-option-title">
                                                                <?php echo apply_filters('wpml_translate_single_string', $bet_option['bet_option_name'], 'BetPress', 'bet-option-' . $bet_option['bet_option_name']); ?>
                                                            </div>

                                                            <div class="bet-option-odd"><?php echo apply_filters('betpress_odd', $bet_option['bet_option_odd']); ?></div>

                                                        </div>
                                                    
                                                    <?php endforeach; ?>  
                                                    
                                                    <div class="clear"></div>

                                                </div>

                                            </div>

                                        <?php endforeach; ?> 

                                    </div>

                                </div>
                            
                                <?php endif; ?>

                            <?php endforeach; ?>    

                        </div>

                    </div>
                    
                    <?php endif; ?>

                <?php endforeach; ?>  

            </div>

        </div>
    
        <?php endif; ?>

    <?php endforeach; ?>    

</div>

<?php else: ?>

<div><?php esc_attr_e('No active bettings at the moment.', 'BetPress'); ?></div>

<?php endif;
