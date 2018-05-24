<?php
//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}
?>
<div class="slips-wrapper">
    
    <?php if ($slips): ?>
    
        <h3><?php printf(esc_attr__('%s slips', 'BetPress'), ucfirst($type)); ?></h3>
    
        <div class="slip-heading" style="background-color: <?php echo $heading_bg; ?>; color: <?php echo $heading_text; ?>">
    
            <div class="title-row"><?php esc_attr_e('Submitted', 'BetPress'); ?></div>
    
            <div class="stake-row"><?php esc_attr_e('Stake', 'BetPress'); ?></div>
    
            <div class="winnings-row"><?php echo $winnings; ?></div>
        
            <div class="clear"></div>
    
        </div>
    
        <?php foreach($slips as $slip): ?>
    
            <div class="slip-row toggle-bet-options" style="background-color: <?php echo $row_bg;?>; color: <?php echo $row_text; ?>">
    
                <div class="title-row"><?php echo betpress_local_tz_time($slip['date']); ?></div>
    
                <div class="stake-row"><?php echo $slip['stake']; ?></div>
    
                <div class="winnings-row"><?php echo $slip['winnings']; ?></div>
        
                <div class="clear"></div>
    
            </div>
    
            <div class="bet-options-wrapper" style="display:none">
    
                <?php betpress_render_bet_options(unserialize($slip['bet_options_ids']), 'page', array('subrow_bg' => $subrow_bg, 'subrow_text' => $subrow_text)); ?>
             
            </div>
    
        <?php endforeach; ?>
    
    <?php else: ?>
    
        <div class="no-results"><?php printf(esc_attr__('You don\'t have any %s slip at the moment.', 'BetPress'), $type); ?></div>
    
    <?php endif; ?>
    
</div>