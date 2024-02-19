<?php
/**
 * Plugin Name: WSUWP Display Local People Profiles
 * Plugin URI: https://github.com/wsuwebteam/wsuwp-plugin-local-profiles
 * Description: Include people profiles on site & in search
 * Version: 1.0.3
 * Requires PHP: 7.0
 * Author: Washington State University, Danial Bleile
 * Author URI: https://web.wsu.edu/
 * Text Domain: wsuwp-plugin-local-profiles
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'WSUWPPLUGINLOCALPROFILES', '1.0.3' );

// Initiate plugin
require_once __DIR__ . '/includes/plugin.php';

// Handle Activation

function wsuwp_plugin_local_profiles_activate() {

	WSUWP\Plugin\Local_Profiles\View_Profile::flush_add_rewrite();

}

register_activation_hook( __FILE__, 'wsuwp_plugin_local_profiles_activate' );

