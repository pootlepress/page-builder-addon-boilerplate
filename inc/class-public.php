<?php

/**
 * Pootle Page Builder Addon Boilerplate public class
 * @property string $token Plugin token
 * @property string $url Plugin root dir url
 * @property string $path Plugin root dir path
 * @property string $version Plugin version
 */
class Pootle_Page_Builder_Addon_Boilerplate_Public{

	/**
	 * @var 	Pootle_Page_Builder_Addon_Boilerplate_Public Instance
	 * @access  private
	 * @since 	1.0.0
	 */
	private static $_instance = null;

	/**
	 * Main Pootle Page Builder Addon Boilerplate Instance
	 * Ensures only one instance of Storefront_Extension_Boilerplate is loaded or can be loaded.
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
	 * @access  private
	 * @since   1.0.0
	 */
	private function __construct() {
		$this->token   =   Pootle_Page_Builder_Addon_Boilerplate::$token;
		$this->url     =   Pootle_Page_Builder_Addon_Boilerplate::$url;
		$this->path    =   Pootle_Page_Builder_Addon_Boilerplate::$path;
		$this->version =   Pootle_Page_Builder_Addon_Boilerplate::$version;
	} // End __construct()

	/**
	 * Adds front end stylesheet and js
	 * @action wp_enqueue_scripts
	 * @since 1.0.0
	 */
	public function enqueue() {
		$token = $this->token;
		$url = $this->url;

		wp_enqueue_style( $token . '-css', $url . '/assets/front-end.css' );
		wp_enqueue_script( $token . '-js', $url . '/assets/front-end.js', array( 'jquery' ) );
	}

	/**
	 * Adds or modifies the row attributes
	 * @param array $attr Row html attributes
	 * @param array $settings Row settings
	 * @return array Row html attributes
	 * @filter pootlepb_row_style_attributes
	 * @since 1.0.0
	 */
	public function row_attr( $attr, $settings ) {
		if ( ! empty( $settings[ $this->token . '_sample_color' ] ) ) {
			$attr['style'] .= 'outline: 12px solid ' . $settings[ $this->token . '_sample_color' ] . ';';
		}
		return $attr;
	}

	/**
	 * Adds or modifies the row attributes
	 * @param array $attr Row html attributes
	 * @param array $settings Row settings
	 * @return array Row html attributes
	 * @filter pootlepb_row_style_attributes
	 * @since 1.0.0
	 */
	public function content_block_attr( $attr, $settings ) {
		if ( ! empty( $settings[ $this->token . '_sample_number' ] ) ) {
			$attr['style'] .= 'position: relative;';
			$attr['style'] .= 'left: ' . $settings[ $this->token . '_sample_number' ] . 'em;';
			$attr['style'] .= 'top: ' . $settings[ $this->token . '_sample_number' ] . 'em;';
		}
		return $attr;
	}
}