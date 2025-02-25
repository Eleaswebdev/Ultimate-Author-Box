<?php

/**
 * Plugin Name: Ultimate Author Box
 * Description: A fully customizable author bio box for WordPress with advanced settings.
 * Version: 1.0.0
 * Author: Eleas Kanchon
 * Author URI: https://github.com/Eleaswebdev
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: ultimate-author-box
 */

defined( 'ABSPATH' ) || exit;

define( 'UAB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'UAB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Load the loader class
require_once UAB_PLUGIN_DIR . 'includes/class-loader.php';

// Initialize the plugin
UAB_Loader::init();

// Register activation and deactivation hooks
register_activation_hook( __FILE__, array( 'UAB_Activator', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'UAB_Deactivator', 'deactivate' ) );
