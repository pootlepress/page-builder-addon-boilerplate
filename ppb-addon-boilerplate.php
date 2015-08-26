<?php
/*
Plugin Name: Pootle Page Builder Addon Boilerplate
Plugin URI: http://pootlepress.com/
Description: Boilerplate for fast track Pootle Page Builder Addon Development
Author: Shramee
Version: 1.0.0
Author URI: http://shramee.com/
*/

/** Plugin admin class */
require 'inc/class-admin.php';
/** Plugin public class */
require 'inc/class-public.php';
/** Including Main Plugin class */
require 'class-ppb-addon-boilerplate.php';
/** Intantiating main plugin class */
Pootle_Page_Builder_Addon_Boilerplate::instance( __FILE__ );

/** Including PootlePress_API_Manager class */
require_once plugin_dir_path( __FILE__ ) . 'pp-api/class-pp-api-manager.php';

/** Instantiating PootlePress_API_Manager */
new PootlePress_API_Manager(
	Pootle_Page_Builder_Addon_Boilerplate::$token,
	'Pootle Page Builder Addon Boilerplate',
	Pootle_Page_Builder_Addon_Boilerplate::$version,
	Pootle_Page_Builder_Addon_Boilerplate::$file,
	Pootle_Page_Builder_Addon_Boilerplate::$token
);
