<?php
//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}
?>
<div class="wrap">
    
    <h2 class="nav-tab-wrapper" id="betpress-settings-tabs">
        
        <a href="#" class="nav-tab <?php echo $last_tab === 'game-settings-tab' ? 'nav-tab-active' : ''; ?>" id="game-settings-tab">
            <?php esc_attr_e('Game settings', 'BetPress'); ?>
        </a>
        
	<a href="#" class="nav-tab <?php echo $last_tab === 'general-settings-tab' ? 'nav-tab-active' : ''; ?>" id="general-settings-tab">
            <?php esc_attr_e('General settings', 'BetPress'); ?>
        </a>
        
	<a href="#" class="nav-tab <?php echo $last_tab === 'paypal-settings-tab' ? 'nav-tab-active' : ''; ?>" id="paypal-settings-tab">
            <?php esc_attr_e('PayPal', 'BetPress'); ?>
        </a>
        
	<a href="#" class="nav-tab <?php echo $last_tab === 'colors-settings-tab' ? 'nav-tab-active' : ''; ?>" id="colors-settings-tab">
            <?php esc_attr_e('Colors', 'BetPress'); ?>
        </a>
        
	<a href="#" class="nav-tab <?php echo $last_tab === 'manual-actions-tab' ? 'nav-tab-active' : ''; ?>" id="manual-actions-tab">
            <?php esc_attr_e('Manual actions', 'BetPress'); ?>
        </a>
        
    </h2>
    
    <table class="form-table betpress-settings-table" id="manual-actions-table" <?php echo $last_tab === 'manual-actions-tab' ? '' : 'style="display:none"'; ?>>
        
        <tr>
            
            <th><?php esc_attr_e('Note', 'BetPress'); ?></th>
            
            <td class="help-info">
                
                <?php esc_attr_e('Please avoid using the manual actions, these should be used in specific cases only.', 'BetPress'); ?>
                
            </td>
            
        </tr>
        
        <tr valign="top">

            <th scope="row">

                <?php esc_attr_e('Check all awaiting slips', 'BetPress'); ?>

            </th>

            <td>

                <a class="button-secondary" href="<?php echo $page_url; ?>&betpress=check_slips">

                    <?php esc_attr_e('Check', 'BetPress'); ?>

                </a>

            </td>

        </tr>

        <tr valign="top">

            <th scope="row">

                <?php esc_attr_e('Check all slips', 'BetPress'); ?>

            </th>

            <td>

                <a class="button-secondary" href="<?php echo $page_url; ?>&betpress=check_all_slips">

                    <?php esc_attr_e('Check all', 'BetPress'); ?>

                </a>

            </td>

        </tr>

        <tr valign="top">

            <th scope="row">

                <?php esc_attr_e('Restart users points', 'BetPress'); ?>

            </th>

            <td>

                <a class="button-secondary" href="<?php echo $page_url; ?>&betpress=restart_points">

                    <?php esc_attr_e('Reset', 'BetPress'); ?>

                </a>

            </td>

        </tr>

    </table>

    <form method="post" action="options.php" novalidate>

        <?php settings_fields('bp_settings_group'); ?>
        <?php do_settings_sections('bp_settings_group'); ?>

        <table class="form-table betpress-settings-table" id="game-settings-table" <?php echo $last_tab === 'game-settings-tab' ? '' : 'style="display:none"'; ?>>

            <tr valign="top">

                <th scope="row">

                    <label for="bp_starting_points"><?php esc_attr_e('Starting points', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="number" min="1" step="any" id="bp_starting_points" name="bp_starting_points" value="<?php echo esc_attr(get_option('bp_starting_points')); ?>" />

                    <span class="help-info"><?php esc_attr_e('This is how many points the users have when they start.', 'BetPress'); ?></span>

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="bp_close_bets"><?php esc_attr_e('Close bets earlier', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="number" min="1" step="1" id="bp_close_bets" name="bp_close_bets" value="<?php echo esc_attr(get_option('bp_close_bets')); ?>" />

                    <span class="help-info"><?php esc_attr_e('This will prevent users from betting X seconds before the bet event starts. (where X is what you enter)', 'BetPress'); ?></span>

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="bp_min_stake"><?php esc_attr_e('Minimum allowed stake', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="number" min="0.01" step="0.01" id="bp_min_stake" name="bp_min_stake" value="<?php echo esc_attr(get_option('bp_min_stake')); ?>" />

                    <span class="help-info"><?php esc_attr_e('The minimum stake per betting slip.', 'BetPress'); ?></span>

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="bp_max_stake"><?php esc_attr_e('Maximum allowed stake', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="number" min="0.01" step="0.01" id="bp_max_stake" name="bp_max_stake" value="<?php echo esc_attr(get_option('bp_max_stake')); ?>" />

                    <span class="help-info"><?php esc_attr_e('The maximum stake per betting slip.', 'BetPress'); ?></span>

                </td>

            </tr>

        </table>

        <table class="form-table betpress-settings-table" id="paypal-settings-table" <?php echo $last_tab === 'paypal-settings-tab' ? '' : 'style="display:none"'; ?>>
        
            <tr>

                <th><?php esc_attr_e('Note', 'BetPress'); ?></th>

                <td class="help-info">

                   <?php printf(esc_attr__('%s Upgrade to the full version of BetPress to enable this tab. %s', 'BetPress'), '<a href="http://web-able.com/betpress/" target="_blank">', '</a>'); ?>

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="paypal-mail"><?php esc_attr_e('PayPal mail', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" id="paypal-mail" name="bp_paypal_mail" value="<?php echo esc_attr(get_option('bp_paypal_mail')); ?>" class="regular-text" disabled />
                    
                    <span class="help-info"><?php esc_attr_e('Make sure this is your PayPal mail.', 'BetPress'); ?></span>

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="bp_max_points_to_buy"><?php esc_attr_e('Maximum points to buy', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="number" min="0" step="1" id="bp_max_points_to_buy" name="bp_max_points_to_buy" value="<?php echo esc_attr(get_option('bp_max_points_to_buy')); ?>" disabled />

                    <span class="help-info"><?php esc_attr_e('The total amount of points that every user is allowed to buy (per leaderboard).', 'BetPress'); ?></span>

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="bp_max_allowed_points"><?php esc_attr_e('Allow buy if points are below', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="number" min="0" step="1" id="bp_max_allowed_points" name="bp_max_allowed_points" value="<?php echo esc_attr(get_option('bp_max_allowed_points')); ?>" disabled />

                    <span class="help-info"><?php esc_attr_e('Users that current points are above this number, are NOT able to buy points at all.', 'BetPress'); ?></span>

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="paypal-url-fail"><?php esc_attr_e('Return URL if cancelled', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" id="paypal-url-fail" name="bp_paypal_url_fail" value="<?php echo esc_attr(get_option('bp_paypal_url_fail')); ?>" class="regular-text" disabled />

                    <span class="help-info"><?php esc_attr_e('Where to send the user if the payment is cancelled.', 'BetPress'); ?></span>

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="paypal-token"><?php esc_attr_e('PayPal token', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" id="paypal-token" name="bp_paypal_token" value="<?php echo esc_attr(get_option('bp_paypal_token')); ?>" class="large-text" disabled />

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="paypal-sandbox"><?php esc_attr_e('Sandbox?', 'BetPress'); ?></label>

                </th>

                <td>

                    <input 
                        type="checkbox"
                        id="paypal-sandbox"
                        name="bp_paypal_sandbox"
                        value="yes"
                        disabled
                        <?php echo strcmp(get_option('bp_paypal_sandbox'), BETPRESS_VALUE_YES) === 0 ? 'checked' : ''; ?> />

                    <span class="help-info"><?php esc_attr_e('Use it to test before going live (it\'s PayPal feature which allow us to test without actual payments).', 'BetPress'); ?></span>

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="paypal-success-message"><?php esc_attr_e('Message if payment is done.', 'BetPress'); ?></label>

                </th>

                <td>

                    <textarea
                        id="paypal-success-message"
                        name="bp_paypal_success_message"
                        cols="80"
                        rows="10"
                        class="large-text"
                        disabled
                        ><?php echo get_option('bp_paypal_success_message'); ?></textarea>

                    <span class="help-info"><?php esc_attr_e('This message will be displayed to the user only if he paid successfully.', 'BetPress'); ?></span>

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="paypal-error-message"><?php esc_attr_e('Message if payment failed.', 'BetPress'); ?></label>

                </th>

                <td>

                    <textarea
                        id="paypal-error-message"
                        name="bp_paypal_error_message"
                        cols="80"
                        rows="10"
                        class="large-text"
                        disabled
                        ><?php echo get_option('bp_paypal_error_message'); ?></textarea>

                    <span class="help-info"><?php esc_attr_e('This message will be displayed to the user only if he failed to pay.', 'BetPress'); ?></span>

                </td>

            </tr>

        </table>

        <table class="form-table betpress-settings-table" id="colors-settings-table" <?php echo $last_tab === 'colors-settings-tab' ? '' : 'style="display:none"'; ?>>

            <tr valign="top">

                <th scope="row">

                    <h3><?php esc_attr_e('Bettings colors', 'BetPress'); ?></h3>

                </th>

                <td></td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="sport-title-bg"><?php esc_attr_e('Sport title background', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_sport_title_bg_color" id="sport-title-bg" value="<?php echo get_option('bp_sport_title_bg_color'); ?>" class="color-picker" />

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="sport-title-text"><?php esc_attr_e('Sport title text', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_sport_title_text_color" id="sport-title-text" value="<?php echo get_option('bp_sport_title_text_color'); ?>" class="color-picker" />

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="sport-container-bg"><?php esc_attr_e('Sport container background', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_sport_container_bg_color" id="sport-container-bg" value="<?php echo get_option('bp_sport_container_bg_color'); ?>" class="color-picker" />

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="event-title-bg"><?php esc_attr_e('Event title background', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_event_title_bg_color" id="event-title-bg" value="<?php echo get_option('bp_event_title_bg_color'); ?>" class="color-picker" />

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="event-title-text"><?php esc_attr_e('Event title text', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_event_title_text_color" id="event-title-text" value="<?php echo get_option('bp_event_title_text_color'); ?>" class="color-picker" />

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="event-container-bg"><?php esc_attr_e('Event container background', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_event_container_bg_color" id="event-container-bg" value="<?php echo get_option('bp_event_container_bg_color'); ?>" class="color-picker" />

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="bet-event-title-bg"><?php esc_attr_e('Bet event title background', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_bet_event_title_bg_color" id="bet-event-title-bg" value="<?php echo get_option('bp_bet_event_title_bg_color'); ?>" class="color-picker" />

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="bet-event-title-text"><?php esc_attr_e('Bet event title text', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_bet_event_title_text_color" id="bet-event-title-text" value="<?php echo get_option('bp_bet_event_title_text_color'); ?>" class="color-picker" />

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="cat-container-bg"><?php esc_attr_e('Cat container background', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_cat_container_bg_color" id="cat-container-bg" value="<?php echo get_option('bp_cat_container_bg_color'); ?>" class="color-picker" />

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="cat-title-bg"><?php esc_attr_e('Cat title background', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_cat_title_bg_color" id="cat-title-bg" value="<?php echo get_option('bp_cat_title_bg_color'); ?>" class="color-picker" />

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="cat-title-text"><?php esc_attr_e('Cat title text', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_cat_title_text_color" id="cat-title-text" value="<?php echo get_option('bp_cat_title_text_color'); ?>" class="color-picker" />

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="button-bg"><?php esc_attr_e('Button background', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_button_bg_color" id="button-bg" value="<?php echo get_option('bp_button_bg_color'); ?>" class="color-picker" />

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="button-text"><?php esc_attr_e('Button text', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_button_text_color" id="button-text" value="<?php echo get_option('bp_button_text_color'); ?>" class="color-picker" />

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <h3><?php esc_attr_e('Featured colors', 'BetPress'); ?></h3>

                </th>

                <td></td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="featured-heading-bg"><?php esc_attr_e('Heading background', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_featured_heading_bg_color" id="featured-heading-bg" value="<?php echo get_option('bp_featured_heading_bg_color'); ?>" class="color-picker" />

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="featured-heading-text"><?php esc_attr_e('Heading text', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_featured_heading_text_color" id="featured-heading-text" value="<?php echo get_option('bp_featured_heading_text_color'); ?>" class="color-picker" />

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="featured-bet-event-bg"><?php esc_attr_e('Bet event background', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_featured_name_bg_color" id="featured-bet-event-bg" value="<?php echo get_option('bp_featured_name_bg_color'); ?>" class="color-picker" />

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="featured-bet-event-text"><?php esc_attr_e('Bet event text', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_featured_name_text_color" id="featured-bet-event-text" value="<?php echo get_option('bp_featured_name_text_color'); ?>" class="color-picker" />

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="featured-button-bg"><?php esc_attr_e('Button background', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_featured_button_bg_color" id="featured-button-bg" value="<?php echo get_option('bp_featured_button_bg_color'); ?>" class="color-picker" />

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="featured-button-text"><?php esc_attr_e('Button text', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_featured_button_text_color" id="featured-button-text" value="<?php echo get_option('bp_featured_button_text_color'); ?>" class="color-picker" />

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <h3><?php esc_attr_e('Leaderboards colors', 'BetPress'); ?></h3>

                </th>

                <td></td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="leaderboard-table-text"><?php esc_attr_e('Table text', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_lb_table_text_color" id="leaderboard-table-text" value="<?php echo get_option('bp_lb_table_text_color'); ?>" class="color-picker" />

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="leaderboard-heading-bg"><?php esc_attr_e('Heading background', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_lb_heading_bg_color" id="leaderboard-heading-bg" value="<?php echo get_option('bp_lb_heading_bg_color'); ?>" class="color-picker" />

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="leaderboard-odd-bg"><?php esc_attr_e('Odd row background', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_lb_odd_bg_color" id="leaderboard-odd-bg" value="<?php echo get_option('bp_lb_odd_bg_color'); ?>" class="color-picker" />

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="leaderboard-even-bg"><?php esc_attr_e('Even row background', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_lb_even_bg_color" id="leaderboard-even-bg" value="<?php echo get_option('bp_lb_even_bg_color'); ?>" class="color-picker" />

                </td>

            </tr>
            
            <tr valign="top">

                <th scope="row">

                    <h3><?php esc_attr_e('Slips colors', 'BetPress'); ?></h3>

                </th>

                <td></td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="slip-heading-bg"><?php esc_attr_e('Heading background', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_slip_heading_bg_color" id="slip-heading-bg" value="<?php echo get_option('bp_slip_heading_bg_color'); ?>" class="color-picker" />

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="slip-heading-text"><?php esc_attr_e('Heading text', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_slip_heading_text_color" id="slip-heading-text" value="<?php echo get_option('bp_slip_heading_text_color'); ?>" class="color-picker" />

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="slip-row-bg"><?php esc_attr_e('Row background', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_slip_row_bg_color" id="slip-row-bg" value="<?php echo get_option('bp_slip_row_bg_color'); ?>" class="color-picker" />

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="slip-row-text"><?php esc_attr_e('Row text', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_slip_row_text_color" id="slip-row-text" value="<?php echo get_option('bp_slip_row_text_color'); ?>" class="color-picker" />

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="slip-subrow-bg"><?php esc_attr_e('Subrow background', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_slip_subrow_bg_color" id="slip-subrow-bg" value="<?php echo get_option('bp_slip_subrow_bg_color'); ?>" class="color-picker" />

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="slip-subrow-text"><?php esc_attr_e('Subrow text', 'BetPress'); ?></label>

                </th>

                <td>

                    <input type="text" name="bp_slip_subrow_text_color" id="slip-subrow-text" value="<?php echo get_option('bp_slip_subrow_text_color'); ?>" class="color-picker" />

                </td>

            </tr>

        </table>

        <table class="form-table betpress-settings-table" id="general-settings-table" <?php echo $last_tab === 'general-settings-tab' ? '' : 'style="display:none"'; ?>>
        
            <tr>

                <th><?php esc_attr_e('Note', 'BetPress'); ?></th>

                <td class="help-info">

                    <?php printf(esc_attr__('%s Upgrade to the full version of BetPress to enable this tab. %s', 'BetPress'), '<a href="http://web-able.com/betpress/" target="_blank">', '</a>'); ?>

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="bp_default_odd_type"><?php esc_attr_e('Default odd type', 'BetPress'); ?></label>

                </th>

                <td>
                    
                    <select id="bp_default_odd_type" name="bp_default_odd_type" disabled>
                        
                        <?php foreach ($odd_types as $odd_type_db => $odd_type_translated): ?>
                        
                            <option value="<?php echo $odd_type_db ?>" <?php echo $odd_type_db === get_option('bp_default_odd_type') ? 'selected' : ''; ?>>
                                
                                <?php echo $odd_type_translated ?>
                                
                            </option>
                        
                        <?php endforeach; ?>
                        
                    </select>

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="bp_one_win_per_cat"><?php esc_attr_e('Only one winning bet option per category?', 'BetPress'); ?></label>

                </th>

                <td>
                    
                    <input 
                        type="checkbox"
                        id="bp_one_win_per_cat"
                        name="bp_one_win_per_cat"
                        value="yes"
                        <?php echo strcmp(get_option('bp_one_win_per_cat'), BETPRESS_VALUE_YES) === 0 ? 'checked' : ''; ?>
                        disabled />

                    <span class="help-info">
                        <?php esc_attr_e('Uncheck this if more than one bet option of same category could be winning. '
                                        . 'Otherwise when you mark bet option as winning, the system will auto-mark all '
                                        . 'the other bet options of that same category as losing. Fe you should uncheck this '
                                        . 'if you are using the auto-importer and its Over/Under category.', 'BetPress'); ?>
                    </span>

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="bp_only_int_stakes"><?php esc_attr_e('Stakes must be whole numbers?', 'BetPress'); ?></label>

                </th>

                <td>
                    
                    <input 
                        type="checkbox"
                        id="bp_only_int_stakes"
                        name="bp_only_int_stakes"
                        value="yes"
                        <?php echo strcmp(get_option('bp_only_int_stakes'), BETPRESS_VALUE_YES) === 0 ? 'checked' : ''; ?>
                        disabled />

                    <span class="help-info">
                        <?php esc_attr_e('Uncheck this if you want to accept decimal numbers (like 3.4, 5.16 and so) for bet stakes.', 'BetPress'); ?>
                    </span>

                </td>

            </tr>

        </table>
        
        

            <input 
                type="submit" 
                name="submit" 
                id="submit-betpress-settings"
                class="button button-primary"
                value="<?php esc_attr_e('Save settings', 'BetPress'); ?>"
                <?php echo $last_tab === 'manual-actions-tab' ? 'style="display: none"' : ''; ?> />

    </form>
    
</div>