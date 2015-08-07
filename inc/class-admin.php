<?php
/**
 * Pootle Page Builder Addon Boilerplate Admin class
 * @property string token Plugin token
 * @property string $url Plugin root dir url
 * @property string $path Plugin root dir path
 * @property string $version Plugin version
 */
class Pootle_Page_Builder_Addon_Boilerplate_Admin{

	/**
	 * @var 	Pootle_Page_Builder_Addon_Boilerplate_Admin Instance
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * Main Pootle Page Builder Addon Boilerplate Instance
	 * Ensures only one instance of Storefront_Extension_Boilerplate is loaded or can be loaded.
	 * @return Pootle_Page_Builder_Addon_Boilerplate instance
	 * @since 	1.0.0
	 */
	public static function instance() {
		if ( null == self::$_instance ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	} // End instance()

	/**
	 * Constructor function.
	 * @access  private
	 * @since 	1.0.0
	 */
	private function __construct() {
		$this->token   =   Pootle_Page_Builder_Addon_Boilerplate::$token;
		$this->url     =   Pootle_Page_Builder_Addon_Boilerplate::$url;
		$this->path    =   Pootle_Page_Builder_Addon_Boilerplate::$path;
		$this->version =   Pootle_Page_Builder_Addon_Boilerplate::$version;
	} // End __construct()

	/**
	 * Adds row settings panel tab
	 * @param array $tabs The array of tabs
	 * @return array Tabs
	 * @filter pootlepb_row_settings_tabs
	 * @since 	1.0.0
	 */
	public function row_settings_tabs( $tabs ) {
		$tabs[ $this->token ] = array(
			'label' => 'Sample Tab',
			'priority' => 5,
		);
		return $tabs;
	}

	/**
	 * Adds row settings panel fields
	 * @param array $fields Fields to output in row settings panel
	 * @return array Tabs
	 * @filter pootlepb_row_settings_fields
	 * @since 	1.0.0
	 */
	public function row_settings_fields( $fields ) {
		$fields[ $this->token . '_sample_color' ] = array(
			'name' => 'Sample color',
			'type' => 'color',
			'priority' => 1,
			'tab' => $this->token,
			'help-text' => 'This is a sample boilerplate field, Sets 12px outline color.'
		);
		return $fields;
	}

	/**
	 * Adds editor panel tab
	 * @param array $tabs The array of tabs
	 * @return array Tabs
	 * @filter pootlepb_content_block_tabs
	 * @since 	1.0.0
	 */
	public function content_block_tabs( $tabs ) {
		$tabs[ $this->token ] = array(
			'label' => 'Sample Tab',
			'priority' => 5,
		);
		return $tabs;
	}

	/**
	 * Adds content block panel fields
	 * @param array $fields Fields to output in content block panel
	 * @return array Tabs
	 * @filter pootlepb_content_block_fields
	 * @since 	1.0.0
	 */
	public function content_block_fields( $fields ) {
		$fields[ $this->token . '_sample_number' ] = array(
			'name' => 'Sample Number with unit',
			'type' => 'number',
			'priority' => 1,
			'min'  => '0',
			'max'  => '100',
			'step' => '1',
			'unit' => 'em',
			'tab' => $this->token,
			'help-text' => 'This is a sample boilerplate field, Sets left and top offset in em.'
		);
		return $fields;
	}

}