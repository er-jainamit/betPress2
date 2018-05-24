<?php
//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}
?>
<div class="admin-dashboard-wrapper">
    
    <div class="admin-dashboard-heading">
        
        <h4><?php esc_attr_e('Started bet events waiting for your actions', 'BetPress'); ?></h4>
        
    </div>
    
<?php foreach ($bet_events as $bet_event): ?>
    
    <div class="admin-dashboard-row">
        
        <a href="<?php echo $admin_url; ?>&event=<?php echo $bet_event['event_id'];?>&bet-event=<?php echo $bet_event['bet_event_id']; ?>">
            
            <?php echo $bet_event['bet_event_name']; ?>
        
        </a>
        
    </div>
    
<?php endforeach; ?>
    
</div>