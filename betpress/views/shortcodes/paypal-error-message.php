<?php
//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}
?>
<div class="paypal-error-message">
    
    <?php echo $paypal_error_message; ?>
    
</div>