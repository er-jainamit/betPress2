<?php
//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}
?>
<?php if ($featured_bet_events): ?>

<div class="table" id="featured-table">
    
    <?php if ($show_heading_row): ?>
    
    <div class="table-heading-row" style="background-color: <?php echo $heading_bg; ?>; color: <?php echo $heading_text; ?>">
        
        <div class="table-col-featured-bet-event-heading">
            
            <?php esc_attr_e('Game', 'BetPress'); ?>
            
        </div>
        
        <div class="table-col-featured-options-heading">
            
            <?php esc_attr_e('Options', 'BetPress'); ?>
            
        </div>
        
    </div>
    
    <?php endif; ?>

    <?php foreach ($featured_bet_events as $bet_event_id => $bet_event): ?>

        <div class="table-row">

            <div class="table-col-featured-bet-event" id="featured-name-<?php echo $bet_event_id; ?>" style="background-color: <?php echo $name_bg; ?>; color: <?php echo $name_text; ?>">
                
                <?php echo apply_filters('wpml_translate_single_string', $bet_event['name'], 'BetPress', 'bet-event-' . $bet_event['name']); ?>
                
            </div>

            <div class="table-col-featured-options">

                <?php foreach ($bet_event['options'] as $bet_option): ?>

                    <div class="featured-bet-option-wrapper"
                         id="bet-option-btn-<?php echo $bet_option['bet_option_id'] ?>"
                         style="width: <?php echo $bet_event['css_width']; ?>%;
                            <?php echo (true === $show_border) ? '' : 'border: none;' ?>
                            background-color: <?php echo $button_bg; ?>;
                            color: <?php echo $button_text; ?>"
                    >

                        <div class="featured-bet-option-title">
                            
                            <?php echo apply_filters('wpml_translate_single_string', $bet_option['bet_option_name'], 'BetPress', 'bet-option-' . $bet_option['bet_option_name']); ?>
                        
                        </div>

                        <div class="featured-bet-option-odd">
                            
                            <?php echo apply_filters('betpress_odd', $bet_option['bet_option_odd']); ?>
                        
                        </div>

                    </div>

                <?php endforeach; ?>   

            </div>

        </div>

    <?php endforeach; ?>

</div>

<?php else: ?>

<div><?php esc_attr_e('No featured bettings at the moment.', 'BetPress'); ?></div>

<?php endif;
