<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.m-dev.net
 * @since             1.0.0
 * @package           Wp_Cars
 *
 * @wordpress-plugin
 * Plugin Name:       WP Cars Plugin
 * Plugin URI:        http://www.m-dev.net
 * Description:       This is a short description of WP Cars Plugin.
 * Version:           1.0.0
 * Author:            Maksim Petrenko
 * Author URI:        http://www.m-dev.net
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-cars
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-cars-activator.php
 */
function activate_wp_cars() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-cars-activator.php';
	Wp_Cars_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-cars-deactivator.php
 */
function deactivate_wp_cars() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-cars-deactivator.php';
	Wp_Cars_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_cars' );
register_deactivation_hook( __FILE__, 'deactivate_wp_cars' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-cars.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_cars() {

	$plugin = new Wp_Cars();
	$plugin->run();

}
run_wp_cars();
