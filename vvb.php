<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.elk-lab.com
 * @since             1.0.0
 * @package           Vvb
 *
 * @wordpress-plugin
 * Plugin Name:       Visa Vertical Booking
 * Plugin URI:        http://www.visamultimedia.com/
 * Description:       This plugin integrates a Vertical Booking reservation form.
 * Version:           1.1.2
 * Author:            VisaMultimedia
 * Author URI:        http://www.visamultimedia.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       visa-vertical-booking
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
define( 'VVB_VERSION', '1.1.2' );

/**
 * Current environment state.
 *
 */
define( 'VVB_ENVIRONMENT', 'production' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-vvb-activator.php
 */
function activate_vvb() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vvb-activator.php';
	Vvb_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-vvb-deactivator.php
 */
function deactivate_vvb() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vvb-deactivator.php';
	Vvb_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_vvb' );
register_deactivation_hook( __FILE__, 'deactivate_vvb' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-vvb.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_vvb() {

	$plugin = new Vvb();
	$plugin->run();

}
run_vvb();
