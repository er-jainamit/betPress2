jQuery(document).ready(function() {
    
    jQuery('input.color-picker').wpColorPicker();
    
    jQuery('#deadline').datetimepicker({
        
        dateFormat : 'dd-mm-yy',
        timeFormat: 'HH:mm z'
    });
    
    //toggle add forms
    jQuery('a[class=page-title-action][id^=add-button-]').on('click', function(event) {
        
        event.preventDefault();
        
        jQuery('#' + this.id + '-target').toggle();
        
        jQuery(this).blur();
    });
    
    //settings page changing tabs
    jQuery('h2#betpress-settings-tabs').on('click', function(event) {
       
        event.preventDefault();
        
        //do nothing when clicked on empty space
        if( ! jQuery(event.target).is('a') ) {
            return;
        }
        
        var id = event.target.id;
        var table_id = id + 'le';
        
        if ('manual-actions-tab' === id) {
            jQuery('#submit-betpress-settings').hide();
        } else {
            jQuery('#submit-betpress-settings').show();
        }
        
        jQuery('.nav-tab.nav-tab-active').removeClass('nav-tab-active');
        
        jQuery(event.target).addClass('nav-tab-active');
        
        jQuery(event.target).blur();
        
        jQuery('table').hide();
        
        jQuery('table#' + table_id).toggle();
        
        betpress_set_cookie('betpress_admin_last_settings_tab', id, 1000, '/');
        
    });
    
    //edit bet option page
    jQuery('select#edit-bet-option-status').on('change', function() {
        
        jQuery('input#check-awaiting-slips').attr('checked', 'checked');
        
    });
    
    //auto-insert data page
    jQuery('select#sports-dropdown').on('change', function() {
        
        var selected_sport_ID = jQuery(this).val();
        
        jQuery('input:checkbox').removeAttr('checked');
        jQuery('div[class^=sport]').hide();
        jQuery('div[class^=bet-event]').hide();
        jQuery('div[class^=event]').hide();
        jQuery('.sport-' + selected_sport_ID).show();
        
    });
    
    //auto-insert data page
    jQuery('input[id^=event]').on('change', function() {
        
        var selected_event_ID = jQuery(this).val();
        selected_event_ID = selected_event_ID.split('/')[0];
        
        var selected_event = jQuery('.event-' + selected_event_ID);
        selected_event.toggle();
        
        if (selected_event.is(':hidden')) {
            
            selected_event.find('input:checkbox').removeAttr('checked');
            
            selected_event.each(function () {
                
                var selected_bet_event_ID = jQuery(this).find('input[id^=bet-event]').val();
                selected_bet_event_ID = selected_bet_event_ID.split('/')[0];
                
                selected_bet_event = jQuery('.bet-event-' + selected_bet_event_ID);
                selected_bet_event.hide();
                selected_bet_event.find('input:checkbox').removeAttr('checked');
                
            });
            
        }
        
    });
    
    //auto-insert data page
    jQuery('input[id^=bet-event]').on('change', function() {
        
        var selected_bet_event_ID = jQuery(this).val();
        selected_bet_event_ID = selected_bet_event_ID.split('/')[0];
        
        jQuery('.bet-event-' + selected_bet_event_ID).toggle();
        
    });
    
    jQuery('a.delete-sport').on('click', function(event) {
       
        if( ! confirm(i18n_admin.sport_delete_confirm_message) ) {
            
            event.preventDefault();
        }
        
    });
    
    jQuery('a.delete-event').on('click', function(event) {
       
        if( ! confirm(i18n_admin.event_delete_confirm_message) ) {
            
            event.preventDefault();
        }
        
    });
    
    jQuery('a.delete-bet-event').on('click', function(event) {
       
        if( ! confirm(i18n_admin.bet_event_delete_confirm_message) ) {
            
            event.preventDefault();
        }
        
    });
    
    jQuery('a.delete-cat').on('click', function(event) {
       
        if( ! confirm(i18n_admin.cat_delete_confirm_message) ) {
            
            event.preventDefault();
        }
        
    });
    
    jQuery('a.delete-bet-option').on('click', function(event) {
       
        if( ! confirm(i18n_admin.bet_option_delete_confirm_message) ) {
            
            event.preventDefault();
        }
        
    });
});

function betpress_set_cookie(cookie_key, cookie_value, hours, path) {
    
    var now = new Date();
    var time = now.getTime();
    time += 3600 * 1000 * hours;
    now.setTime(time);
    
    document.cookie =
            cookie_key + '=' + cookie_value +
            '; expires=' + now.toUTCString() +
            '; path=' + path;
}

function betpress_get_cookie(cookie_key) {
    
    var name = cookie_key + '=';
    var ca = document.cookie.split(';');
    for(var i=0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1);
        if (c.indexOf(name) === 0) return c.substring(name.length,c.length);
    }
    
    return '';
}
