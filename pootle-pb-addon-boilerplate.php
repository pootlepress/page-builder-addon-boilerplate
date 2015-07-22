<?php
/*
Plugin Name: Pootle Page Builder Addon Boilerplate
Plugin URI: http://pootlepress.com/
Description: Boilerplate for fast track Pootle Page Builder Addon Development
Author: Shramee
Version: 0.1.0
Author URI: http://shramee.com/
*/

/** Including Main Plugin class */
require_once 'class-ppb-addon-boilerplate.php';
/** Intantiating main plugin class */
Pootle_Page_Builder_Addon_Boilerplate::instance();

// Pootlepress API Manager
/** Including PootlePress_API_Manager class */
require_once( plugin_dir_path( __FILE__ ) . 'pp-api/class-pp-api-manager.php' );
/** Instantiating PootlePress_API_Manager */
new PootlePress_API_Manager( 'Pootle_Page_Builder_Addon_Boilerplate', 'Pootle Page Builder Addon Boilerplate', '0.1.0', __FILE__, null, 'http://shramee.thisistap.com/' );
