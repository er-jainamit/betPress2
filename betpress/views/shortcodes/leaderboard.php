<?php
//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}
?>
<h3>
    <?php printf(
            __('Leaderboard %s', 'BetPress'),
            apply_filters('wpml_translate_single_string', $name, 'BetPress', 'lb-' . $name)
        ); ?>
</h3>
    
<?php if ($results): ?>

<div class="table" style="color: <?php echo $table_text; ?>">
    
    <div class="table-heading-row" style="background-color: <?php echo $heading_bg; ?>">

        <div class="table-col-lb-pos">

            <?php esc_attr_e('#', 'BetPress'); ?>
            
        </div>

        <div class="table-col-lb-user">

            <?php esc_attr_e('Username', 'BetPress'); ?>

        </div>

        <div class="table-col-lb-points">

            <?php esc_attr_e('Points', 'BetPress'); ?>

        </div>

    </div>
    
<?php $count = 2;?>
    
<?php foreach ($results as $row): ?>

    <div class="table-row" style="background-color: <?php echo $count % 2 === 0 ? $odd_bg : $even_bg?>">

        <div class="table-col-lb-pos">
            
            <?php echo $row['position'] ?>

        </div>

        <div class="table-col-lb-user">
            
            <?php echo $row['nickname'] ?>

        </div>

        <div class="table-col-lb-points">

            <?php echo $row['points'] ?>

        </div>
        
    </div>
    
    <?php $count ++; ?>
    
<?php endforeach; ?>

</div>

<?php if ($skip_paginator === false): ?>

<div class="paginator">
    
    <div class="page-button">
        
        <a <?php if ($current_page !== 1): ?> href="<?php echo $page_url . $symbol ?>lb_page=1" <?php endif; ?>>
            
            <?php esc_attr_e('<<', 'BetPress') ?>
            
        </a>
        
    </div>
    
    <div class="page-button">
        
        <a <?php if ($previous_page > 0): ?> href="<?php echo $page_url . $symbol ?>lb_page=<?php echo $previous_page ?>" <?php endif; ?>>
            
            <?php esc_attr_e('<', 'BetPress') ?>
            
        </a>
        
    </div>
    
    <div class="page-button">
            
        <?php echo $current_page ?>
        
    </div>
    
    <div class="page-button">
        
        <a <?php if ($next_page <= $last_page): ?>href="<?php echo $page_url . $symbol ?>lb_page=<?php echo $next_page ?>" <?php endif; ?>>
            
            <?php esc_attr_e('>', 'BetPress') ?>
            
        </a>
        
    </div>
    
    <div class="page-button">
        
        <a <?php if ($current_page !== $last_page): ?> href="<?php echo $page_url . $symbol ?>lb_page=<?php echo $last_page ?>" <?php endif; ?>>
            
            <?php esc_attr_e('>>', 'BetPress') ?>
            
        </a>
        
    </div>
    
</div>

<?php endif; ?>
    
<?php else: ?>
    
    <div class="error">
            
        <?php esc_attr_e('No results found.', 'BetPress'); ?>
        
    </div>

<?php endif;