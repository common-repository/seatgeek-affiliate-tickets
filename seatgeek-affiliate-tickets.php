<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.wisersteps.com
 * @since             1.0.3
 * @package           Seatgeek_Affiliate_Tickets
 *
 * @wordpress-plugin
 * Plugin Name:       Seatgeek Affiliate Tickets
 * Plugin URI:        seatgeek-affiliate-system
 * Description:       Show events and affiliate tickets from Seatgeek website using a simple shortcode.
 * Version:           1.0.3
 * Author:            Omar Kasem
 * Author URI:        https://www.wisersteps.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       seatgeek-affiliate-tickets
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SEATGEEK_AFFILIATE_TICKETS_VERSION', '1.0.3' );
require_once( dirname( __FILE__ ) .'/includes/inc/titan-framework/titan-framework-embedder.php' );


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-seatgeek-affiliate-tickets-activator.php
 */
function activate_seatgeek_affiliate_tickets() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-seatgeek-affiliate-tickets-activator.php';
	Seatgeek_Affiliate_Tickets_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-seatgeek-affiliate-tickets-deactivator.php
 */
function deactivate_seatgeek_affiliate_tickets() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-seatgeek-affiliate-tickets-deactivator.php';
	Seatgeek_Affiliate_Tickets_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_seatgeek_affiliate_tickets' );
register_deactivation_hook( __FILE__, 'deactivate_seatgeek_affiliate_tickets' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-seatgeek-affiliate-tickets.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_seatgeek_affiliate_tickets() {

	$plugin = new Seatgeek_Affiliate_Tickets();
	$plugin->run();

}
run_seatgeek_affiliate_tickets();
