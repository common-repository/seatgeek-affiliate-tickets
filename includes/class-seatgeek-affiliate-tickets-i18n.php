<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.wisersteps.com
 * @since      1.0.0
 *
 * @package    Seatgeek_Affiliate_Tickets
 * @subpackage Seatgeek_Affiliate_Tickets/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Seatgeek_Affiliate_Tickets
 * @subpackage Seatgeek_Affiliate_Tickets/includes
 * @author     Omar Kasem <omar.kasem207@gmail.com>
 */
class Seatgeek_Affiliate_Tickets_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'seatgeek-affiliate-tickets',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
