<?php

//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}

function betpress_auto_insert_controller() {
    
    $pass['xml_data'] = array();
    betpress_get_view('auto-insert', 'admin', $pass);
    
}
