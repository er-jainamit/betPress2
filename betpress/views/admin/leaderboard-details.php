<?php
//don't allow direct access via url
if ( ! defined('ABSPATH') ) {
    exit();
}
?>
<div class="wrap">

    <h2><?php printf(__('Details for %s', 'BetPress'), $leaderboard['leaderboard_name']); ?></h2>

    <table class="widefat">

        <thead>

            <tr>

                <th class="row-title"><?php esc_attr_e('Position', 'BetPress'); ?></th>

                <th><?php esc_attr_e('Username', 'BetPress'); ?></th>

                <th><?php esc_attr_e('Points', 'BetPress'); ?></th>

            </tr>

        </thead>

        <tbody>

            <?php if ($results): ?>

                <?php foreach ($results as $row): ?>

                    <tr>

                        <td class="row-title">

                            <?php echo $row['position']; ?>

                        </td>

                        <td>

                            <?php echo $row['nickname']; ?>

                        </td>

                        <td>

                            <?php echo $row['points']; ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>

                    <td>

                        <h4><?php esc_attr_e('Nothing to show', 'BetPress'); ?></h4>

                    </td>

                </tr>

            <?php endif; ?>

        </tbody>

        <tfoot>

            <tr>

                <th class="row-title"><?php esc_attr_e('Position', 'BetPress'); ?></th>

                <th><?php esc_attr_e('Username', 'BetPress'); ?></th>

                <th><?php esc_attr_e('Points', 'BetPress'); ?></th>

            </tr>

        </tfoot>

    </table>

    <div class="help-info">

        <a href="<?php echo $back_url; ?>"><?php esc_attr_e('Go back to leaderboards', 'BetPress'); ?></a>

    </div>

</div>