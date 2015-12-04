<?php
/*
Plugin Name: Pootle Page Builder Addon Boilerplate
Plugin URI: http://pootlepress.com/
Description: Boilerplate for fast track Pootle Page Builder Addon Development
Author: Shramee
Version: 1.0.0
Author URI: http://shramee.com/
@developer shramee <shramee.srivastav@gmail.com>
*/

/** Plugin admin class */
require 'inc/class-admin.php';
/** Plugin public class */
require 'inc/class-public.php';
/** Including Main Plugin class */
require 'class-ppb-addon-boilerplate.php';
/** Intantiating main plugin class */
Pootle_Page_Builder_Addon_Boilerplate::instance( __FILE__ );

/** Addon update API */
add_action( 'plugins_loaded', 'Pootle_Page_Builder_Addon_Boilerplate_api_init' );

/**
 * Instantiates Pootle_Page_Builder_Addon_Manager with current add-on data
 * @action plugins_loaded
 */
function Pootle_Page_Builder_Addon_Boilerplate_api_init() {
	//Return if POOTLEPB_DIR not defined
	if ( ! defined( 'POOTLEPB_DIR' ) ) { return; }
	/** Including PootlePress_API_Manager class */
	require_once POOTLEPB_DIR . 'inc/addon-manager/class-manager.php';
	/** Instantiating PootlePress_API_Manager */
	new Pootle_Page_Builder_Addon_Manager(
		Pootle_Page_Builder_Addon_Boilerplate::$token,
		'Pootle Page Builder Addon Boilerplate',
		Pootle_Page_Builder_Addon_Boilerplate::$version,
		Pootle_Page_Builder_Addon_Boilerplate::$file,
		Pootle_Page_Builder_Addon_Boilerplate::$token
	);
}
