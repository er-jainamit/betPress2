jQuery(document).ready(function () {
    
    //make stake input height equals the submit button height
    jQuery('#stake-input').css('min-height', jQuery('#submit-slip-button').css('height'));
    
    //fix height bugs in featured page 
    jQuery('.table-col-featured-options').each(function() {
        var this_height = jQuery(this).css('height');
        var children = jQuery(this).children('.featured-bet-option-wrapper');
        
        jQuery(this).siblings('.table-col-featured-bet-event').css('height', this_height);
        
        jQuery.each(children, function (index, element) {
            jQuery(element).css('height', this_height);
        });
        
    });
    
    //odd changing redirection
    jQuery('#odd-type-switcher-dropdown').on('change', function () {
        
        var selected_option = jQuery(this).find('option:selected').val();
        var current_url = window.location.href;
        var query_params = window.location.search;
        var get_symbol = (query_params === '') ? '?' : '&';
        
        //change the desired odd
        window.location.replace(current_url + get_symbol + 'odd_type_changing=' + selected_option);
    });
    
    //toggle bettings
    jQuery('span[class=toggle-btn]').on('click', function () {
        
        var selected_id = this.id;
        var selected = selected_id.split('--');
        var type = selected[0];
        var id = selected[1];
       
        var container = jQuery('#' + type + '-container-' + id);
        
        this.innerHTML = container.css('display') === 'none' ? i18n_front.toggle_symbol_minus : i18n_front.toggle_symbol_plus;
        
        container.slideToggle();
        
    });
    
    //add bet option
    jQuery('div[id^=bet-option-btn]').on('click', function () {
        
        jQuery('.bets-holder').html(i18n_front.loading);
        
        jQuery('html, body').animate({
            scrollTop: jQuery("#betslip-wrapper").offset().top - 70
        }, 1000);
        
        var selected_option_id = this.id;
        var id = selected_option_id.split('-')[3];
        var name = this.innerHTML;
        
        jQuery.post(ajaxurl, {
        
            action: 'add_bet_option',
            bet_option_id: id,
            bet_option_name: name
            
        }, function (response) {
 
            jQuery('.bets-holder').html(response);
            
        });
    });   
    
    //delete bet option
    jQuery('.bets-holder').on('click', '.delete-bet-option', function (event) {
        
        event.preventDefault();
        
        jQuery('.bets-holder').html(i18n_front.loading);
        
        var id = this.id.split('-')[1];
        
        jQuery.post(ajaxurl, {
            
            action: 'delete_bet_option',
            bet_option_id: id
            
        }, function (response) {
            
            jQuery('.bets-holder').html(response);
        });
    });
    
    //submit bet slip
    jQuery('button[id=submit-slip-button]').on('click', function (event) {
        
        event.preventDefault();
        
        jQuery(this).blur();
        
        jQuery('.bets-holder').html(i18n_front.loading);
        
        var bet_stake = jQuery('#stake-input').val();
        
        jQuery.post(ajaxurl, {
            
            action: 'submit_bet_slip',
            bet_stake: bet_stake
            
        }, function (response) {
            
            jQuery('.bets-holder').html(response);
            
            jQuery('.points-holder').html(i18n_front.loading);
            
            jQuery.post(ajaxurl, {
        
                action: 'points_change'
            
            }, function (response) {
 
                jQuery('.points-holder').html(response);
            
            });
        });
    });
    
    //slips page, toggling a slip's bet options
    jQuery('.toggle-bet-options').on('click', function () {
        
        jQuery(this).next().toggle();
        
    });
    
});