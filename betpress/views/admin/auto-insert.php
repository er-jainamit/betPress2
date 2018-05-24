<?php
//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}
?>
<div class="wrap">
    
    <h2><?php esc_attr_e('Auto insert data', 'BetPress'); ?></h2>
    
    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
    
        <table class="form-table">

            <tr>

                <th><?php esc_attr_e('Note', 'BetPress'); ?></th>

                <td class="help-info">

                    <?php printf(esc_attr__('%s Upgrade to the full version of BetPress to enable this page. %s', 'BetPress'), '<a href="http://web-able.com/betpress/" target="_blank">', '</a>'); ?>

                </td>

            </tr>

            <tr valign="top">

                <th scope="row"><?php esc_attr_e('Note', 'BetPress'); ?></th>

                <td class="help-info">

                    <?php esc_attr_e('This page may needs several seconds to load due to the large amount of data.', 'BetPress'); ?>

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="sports-dropdown"><?php esc_attr_e('Choose a sport', 'BetPress'); ?></label>

                </th>

                <td>

                    <select name="sport_id" id="sports-dropdown" disabled>

                        <option value="0"><?php esc_attr_e('Select sport', 'BetPress'); ?></option>

                    <?php foreach ($xml_data as $sport => $sport_data): ?>

                        <option value="<?php echo $sport_data['id']; ?>"><?php echo $sport; ?></option>

                    <?php endforeach; ?>

                    </select>

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <label for="auto-activate"><?php esc_attr_e('Auto activate', 'BetPress'); ?></label>

                </th>

                <td>

                    <input 
                        type="checkbox"
                        id="auto-activate"
                        name="auto_activate"
                        value="1"
                        disabled
                    />

                    <span class="help-info"><?php esc_attr_e('If checked, you don\'t need to manually activate every bet event.', 'BetPress'); ?></span>

                </td>

            </tr>

            <tr valign="top">

                <th scope="row">

                    <?php esc_attr_e('Choose events', 'BetPress'); ?>

                </th>

                <td>

    <?php foreach ($xml_data as $sport_name => $events): ?>

        <?php if (count($events) === 1): ?>

                    <div class="sport-<?php echo $events['id']; ?>" style="display:none">

                        <?php esc_attr_e('No events available for this sport at the moment.', 'BetPress'); ?>

                    </div>

        <?php endif; ?>

        <?php if (is_array($events)): ?>

            <?php foreach ($events as $event_name => $bet_events): ?>

                <?php if ('id' != $event_name): ?>

                    <div class="sport-<?php echo $events['id']; ?>" style="display:none">

                        <input 
                            type="checkbox"
                            id="event-<?php echo $bet_events['id']; ?>"
                            name="events[]"
                            value="<?php echo $bet_events['id'] . '/' . $events['id']; ?>"
                            />

                        <label for="event-<?php echo $bet_events['id']; ?>"><?php echo $event_name; ?></label>

                    </div>

                <?php endif; ?>

                <?php if (is_array($bet_events)): ?>

                    <?php foreach ($bet_events as $bet_event_name => $categories): ?>

                        <?php if ('id' != $bet_event_name): ?>

                    <div class="event-<?php echo $bet_events['id']; ?>" style="padding-left:15px;display:none">

                        <input 
                            type="checkbox"
                            id="bet-event-<?php echo $categories['id']; ?>"
                            name="bet_events[]"
                            value="<?php echo $categories['id'] . '/' . $bet_events['id']; ?>"
                            />

                        <label for="bet-event-<?php echo $categories['id']; ?>"><?php echo $bet_event_name; ?></label>

                    </div>

                        <?php endif; ?>

                        <?php if (is_array($categories)): ?>

                            <?php foreach ($categories as $category_name => $bet_options): ?>

                                <?php if ('id' != $category_name): ?>

                    <div class="bet-event-<?php echo $categories['id']; ?>" style="padding-left:30px;display:none">

                        <input 
                            type="checkbox"
                            id="category-<?php echo $bet_options['id']; ?>"
                            name="categories[]"
                            value="<?php echo $bet_options['id'] . '/' . $categories['id']; ?>"
                            />

                        <label for="category-<?php echo $bet_options['id']; ?>"><?php echo $category_name; ?></label>

                    </div>

                                <?php endif; ?>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    <?php endforeach; ?>

                <?php endif; ?>

            <?php endforeach; ?>

        <?php endif; ?>

    <?php endforeach; ?>

                </td>

            </tr>

            <tr>

                <th>

                    <input type="submit" name="inserting_xml_data" value="<?php esc_attr_e('Insert data', 'BetPress'); ?>" class="button-primary" disabled />

                </th>

            </tr>

        </table>
    
    </form>
    
</div>