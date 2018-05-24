<?php

//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}

function betpress_render_admin_dashboard_widget() {
    
    $pass['admin_url'] = get_admin_url(null, 'admin.php?page=betpress-sports-and-events');
    $pass['bet_events'] = betpress_get_bet_options_for_admin();
    betpress_get_view('dashboard-widget', 'admin', $pass);
}

