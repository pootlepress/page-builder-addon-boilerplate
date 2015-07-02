<?php

class Pootle_Page_Builder_Addon_Boilerplate{

	/**
	 * Pootle_Page_Builder_Addon_Boilerplate Instance of main plugin class.
	 *
	 * @var 	object Pootle_Page_Builder_Addon_Boilerplate
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * The token.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public static $token;
	/**
	 * The version number.
	 * @var     string
	 * @access  public
	 * @since   1.0.0
	 */
	public static $version;

	/**
	 * Pootle Page Builder Addon Boilerplate plugin directory URL.
	 *
	 * @var 	string Plugin directory
	 * @access  private
	 * @since 	1.0.0
	 */
	public static $url;

	/**
	 * Pootle Page Builder Addon Boilerplate plugin directory Path.
	 *
	 * @var 	string Plugin directory
	 * @access  private
	 * @since 	1.0.0
	 */
	public static $path;

	/**
	 * Main Pootle Page Builder Addon Boilerplate Instance
	 *
	 * Ensures only one instance of Storefront_Extension_Boilerplate is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @return Pootle_Page_Builder_Addon_Boilerplate instance
	 */
	public static function instance() {
		if ( null == self::$_instance ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	} // End instance()

	/**
	 * Constructor function.
	 *
	 * @access  private
	 * @since   1.0.0
	 */
	private function __construct() {

		self::$token =     'ppb-addon-boilerplate';
		self::$url =       plugin_dir_url( __FILE__ );
		self::$path =      plugin_dir_path( __FILE__ );
		self::$version =   '1.0.0';

		add_action( 'init', array( $this, 'init' ) );
	} // End __construct()

	public function init() {

		if ( class_exists( 'Pootle_Page_Builder' ) ) {

			$this->add_actions();
			$this->add_filters();
		}
	} // End init()

	private function add_actions() {

		//Adding front end JS and CSS in /assets folder
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
	} // End add_actions()

	private function add_filters() {

		//Add Pootle Page Builder Filter hooks here
	} // End add_filters()

	public function enqueue() {
		$token = self::$token;
		$url = self::$url;

		wp_enqueue_style( $token . '-css', $url . '/assets/front-end.css' );
		wp_enqueue_script( $token . '-js', $url . '/assets/front-end.js', array( 'jquery' ) );
	} // End enqueue()

}