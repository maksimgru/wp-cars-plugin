<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://www.m-dev.net
 * @since      1.0.0
 *
 * @package    Wp_Cars_Test
 * @subpackage Wp_Cars_Test/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Wp_Cars_Test
 * @subpackage Wp_Cars_Test/includes
 * @author     Maksim Petrenko <maksimgru@gmail.com>
 */
class Wp_Cars_Test_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		//$plugin_options = Wp_Cars_Test::get_options();
		//$plugin_options['is_install_demo_content'] = 0;
		//Wp_Cars_Test::update_options($plugin_options);
		flush_rewrite_rules();
	}

}
