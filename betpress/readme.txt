=== BetPress ===
Contributors: web-able
Donate link: http://web-able.com/betpress/
Tags: bet, bets, betting, betting game, betting slip, bettings, football, game, odds, soccer, sport, tennis
Requires at least: 3.5
Tested up to: 4.4.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The Lite version of BetPress - sports betting game WordPress plugin.



== Description ==

BetPress is a WordPress plugin that allow your users to place betting slips on sports events and compete against each others.

The main idea of the plugin is to add a fun game to your website where users compete against each other guessing the outcome of different events. It simulates the very basic functionality of a bookmaker's website (like bwin, bet365, betfair etc) where bets are not made with real money but a virtual points.

To make a bet, you have to create a slip having at least one bet option in it. The possible winnings of a slip are calculated by multiplying the odds of every bet option in it by the stake the user made. If all bet options turns out to be winning then the slip is winning. A slip could also end up losing, canceled or timed out. There is a detailed documentation for more info but you can understand how BetPress works by just seeing the demo: http://web-able.com/betpress/demo/
<br />Please note that this is the Lite version of BetPress and in the demo you see the full version which has many extra features.

<h4>BetPress Lite features:</h4><br />
 - Game settings like starting points, min/max bets per slip etc.<br />
 - Leaderboards<br />
 - User adds & deletes bet options from his slip via AJAX (no page refresh)<br />
 - User's unsubmitted slip is saved no matter when he logs in again<br />
 - Prevent user submitting same slip twice<br />
 - Manual actions for emergency cases<br />
 - Unlimited bettings<br />
 - 29 colors settings<br />
 - Reminder widget in the admin dashboard to tell you which bettings are waiting<br />
 - Manually adjust user's points and user's bought points<br />
 - 1 widget containing the user unsubmitted slip and optionally the user's points<br />
 - 4 shortcodes each containing multiple attributes<br />
 - Translation ready<br />
 - WPML compatible<br />
 - Responsive<br />
 - Documented<br />
 - Supported<br />

<h4>BetPress full version features:</h4><br />
 - <strong>Three odd types supported:</strong> European (decimal), UK (fractional) and USA (moneyline)<br />
 - <strong>Semi-automated:</strong> You are always few clicks away from inserting up-to-date sports bettings. The plugin currently gets the data from Betclic API but is developed in a way where the third party provider can be changed anytime and that won't force you to do anything, not even update of the plugin. In other words BetPress won't get broken if Betclic decide to restrict the access to their API.<br />
 - <strong>Monetized:</strong> BetPress allows you to sell points via PayPal and of course there are several settings that allow to set quantity restrictions.<br />
 - + all the features from the Lite version<br />
 - + 1 widget<br />
 - + 1 shortcode<br />
 - + more settings<br />



== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/betpress` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. (Optional) Go to BetPress -> BetPress and take a look at all the settings under the "Game settings" and "Colors" tabs. And of course feel free to change them according to your needs.
4. Go to Appearance -> Widgets and drag the BetPress Slip widget to a widget area that is visible on your pages
5. Go to BetPress -> Leaderboards and open a new leaderboard. Or you may just rename the auto-generated leaderboard if you haven't change the "Starting points" setting.



== Screenshots ==

1. On this page you edit sports and events.

2. This is where you go after clicked the "Manage event" button on the previous screen. Here you manage the games or how we called in the plugin "bet events".

3. This is where you go after clicked the "Modify bet options" button on the previous screen. Here you manage the bet options.

4. This is the Admin Dashboard page in WordPress. You can see a "BetPress" widget telling you which games (bet events) are already started and waiting for you to edit their betting options' statuses.

5. This is the Leaderboards page. By clicking the "See leaderboard" button you will go on another page where you will see all users ordered by their points for that specific leaderboard.

6. This is the Game settings tab in the main BetPress page.

7. This is the start of the Colors tab. There are 29 colors settings in total.

8. This is the Manual actions tab and here you can see the emergency actions you can take when something goes wrong.

9. This is where you edit a specific user. You can change both his points and bought points.

10. This is the Bettings front-end page. One of the two ways your users can add bet options to their current slip.

11. This is the Featured front-end page. The other way of adding bet options.



== Frequently Asked Questions ==

= Can I manually adjust a specific user's bought points? =

Yes, you can. You can also manually adjust a specific user's points in the current active leaderboard.

= I don't like the decimal odd type. What can I do? =

The Lite version supports only the decimal odd type. You can upgrade to the full version of BetPress to have access to the moneyline (USA) and fractional (UK) odd types.

= Can I use the plugin for non-sport related stuff? =

Yes, you can but you have to follow the same structure Parent -> Child -> Grandchild -> Grand-grandchild -> Grand-grand-grandchild where the latest is actually the one your users bets on.

= If I upgrade from BetPress Lite to the full version, would I lose all my data? =

No, no data will be lost.

= If I upgrade and I am not happy afterwards, is there refund? =

Yes, there is 30 day money back guarantee.



== Changelog ==

= 1.0.1 =
* fix images url
* fix some admin views
* fix WPML compatibility
* remove usage of empty() without var

= 1.0 =
* First release of BetPress.



== Upgrade notice ==

No upgrades so far