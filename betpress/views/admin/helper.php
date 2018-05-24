<?php
//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}
?>
<div class="helper-wrapper">
    
    <span class="legend-label">
        
        <h3><?php esc_attr_e('Legend', 'BetPress'); ?></h3>
        
    </span>
    
    <span class="edit-label">
        
        <img src="<?php echo BETPRESS_IMAGE_FOLDER . 'edit-16.png'; ?>" alt="<?php esc_attr_e('Edit', 'BetPress'); ?>" />
        
        <?php esc_attr_e('Edit', 'BetPress'); ?>
        
    </span>
    
    <span class="delete-label">
        
        <img src="<?php echo BETPRESS_IMAGE_FOLDER . 'delete-16.png'; ?>" alt="<?php esc_attr_e('Delete', 'BetPress'); ?>" />
        
        <?php esc_attr_e('Delete', 'BetPress'); ?>
        
    </span>
    
    <span class="move-up-label">
        
        <img src="<?php echo BETPRESS_IMAGE_FOLDER . 'up-arrow-16.png'; ?>" alt="<?php esc_attr_e('Move up', 'BetPress'); ?>" />
        
        <?php esc_attr_e('Move up', 'BetPress'); ?>
        
    </span>
    
    <span class="move-down-label">
        
        <img src="<?php echo BETPRESS_IMAGE_FOLDER . 'down-arrow-16.png'; ?>" alt="<?php esc_attr_e('Move down', 'BetPress'); ?>" />
        
        <?php esc_attr_e('Move down', 'BetPress'); ?>
        
    </span>
    
</div>