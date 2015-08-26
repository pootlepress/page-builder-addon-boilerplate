<?php
/**
 * Pootle Page Builder Addon Boilerplate main class
 * @static string $token Plugin token
 * @static string $file Plugin __FILE__
 * @static string $url Plugin root dir url
 * @static string $path Plugin root dir path
 * @static string $version Plugin version
 */
class Pootle_Page_Builder_Addon_Boilerplate{

	/**
	 * @var 	Pootle_Page_Builder_Addon_Boilerplate Instance
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * @var     string Token
	 * @access  public
	 * @since   1.0.0
	 */
	public static $token;

	/**
	 * @var     string Version
	 * @access  public
	 * @since   1.0.0
	 */
	public static $version;

	/**
	 * @var 	string Plugin main __FILE__
	 * @access  public
	 * @since 	1.0.0
	 */
	public static $file;

	/**
	 * @var 	string Plugin directory url
	 * @access  public
	 * @since 	1.0.0
	 */
	public static $url;

	/**
	 * @var 	string Plugin directory path
	 * @access  public
	 * @since 	1.0.0
	 */
	public static $path;

	/**
	 * @var 	Pootle_Page_Builder_Addon_Boilerplate_Admin Instance
	 * @access  public
	 * @since 	1.0.0
	 */
	public $admin;

	/**
	 * @var 	Pootle_Page_Builder_Addon_Boilerplate_Public Instance
	 * @access  public
	 * @since 	1.0.0
	 */
	public $public;

	/**
	 * Main Pootle Page Builder Addon Boilerplate Instance
	 *
	 * Ensures only one instance of Storefront_Extension_Boilerplate is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @return Pootle_Page_Builder_Addon_Boilerplate instance
	 */
	public static function instance( $file ) {
		if ( null == self::$_instance ) {
			self::$_instance = new self( $file );
		}
		return self::$_instance;
	} // End instance()

	/**
	 * Constructor function.
	 * @param string $file __FILE__ of the main plugin
	 * @access  private
	 * @since   1.0.0
	 */
	private function __construct( $file ) {

		self::$token   =   'ppb-addon-boilerplate';
		self::$file    =   $file;
		self::$url     =   plugin_dir_url( $file );
		self::$path    =   plugin_dir_path( $file );
		self::$version =   '1.0.0';

		add_action( 'init', array( $this, 'init' ) );
	} // End __construct()

	/**
	 * Initiates the plugin
	 * @action init
	 * @since 1.0.0
	 */
	public function init() {

		if ( class_exists( 'Pootle_Page_Builder' ) ) {

			//Initiate admin
			$this->_admin();

			//Initiate public
			$this->_public();

			//Mark this add on as active
			add_filter( 'pootlepb_installed_add_ons', array( $this, 'add_on_active' ) );
		}
	} // End init()

	/**
	 * Initiates admin class and adds admin hooks
	 * @since 1.0.0
	 */
	private function _admin() {
		//Instantiating admin class
		$this->admin = Pootle_Page_Builder_Addon_Boilerplate_Admin::instance();

		//Row settings panel tabs
		add_filter( 'pootlepb_row_settings_tabs', array( $this->admin, 'row_settings_tabs' ) );
		//Row settings panel fields
		add_filter( 'pootlepb_row_settings_fields', array( $this->admin, 'row_settings_fields' ) );
		//Content block panel tabs
		add_filter( 'pootlepb_content_block_tabs', array( $this->admin, 'content_block_tabs' ) );
		//Content block panel fields
		add_filter( 'pootlepb_content_block_fields', array( $this->admin, 'content_block_fields' ) );

	}

	/**
	 * Initiates public class and adds public hooks
	 * @since 1.0.0
	 */
	private function _public() {
		//Instantiating public class
		$this->public = Pootle_Page_Builder_Addon_Boilerplate_Public::instance();

		//Adding front end JS and CSS in /assets folder
		add_action( 'wp_enqueue_scripts', array( $this->public, 'enqueue' ) );
		//Add/Modify row html attributes
		add_filter( 'pootlepb_row_style_attributes', array( $this->public, 'row_attr' ), 10, 2 );
		//Add/Modify content block html attributes
		add_filter( 'pootlepb_content_block_attributes', array( $this->public, 'content_block_attr' ), 10, 2 );

	} // End enqueue()

	/**
	 * Marks this add on as active on
	 * @param array $active Active add ons
	 * @return array Active add ons
	 * @since 1.0.0
	 */
	public function add_on_active( $active ) {

		// To allows ppb add ons page to fetch name, description etc.
		$active[ self::$token ] = self::$file;

		return $active;
	}

}