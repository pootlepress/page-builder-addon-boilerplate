<?php

/**
 * Pooltepress Admin Menu Class
 *
 * @package Update API Manager/Admin
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'PootlePress_API_Manager_Menu' ) ) {
	class PootlePress_API_Manager_Menu {

		// Load admin menu
		public function __construct() {

			add_action( 'admin_menu', array( $this, 'pp_api_menu_add_menu' ) );
			add_action( 'admin_init', array( $this, 'pp_api_menu_load_settings' ) );
		}

		// Add option page menu
		public function pp_api_menu_add_menu() {

			$page = add_options_page( __( $this->settings_menu_title, $this->text_domain ), __( $this->settings_menu_title, $this->text_domain ),
				'manage_options', $this->activation_tab_key, array( $this, 'pp_api_menu_config_page' )
			);
			add_action( 'admin_print_styles-' . $page, array( $this, 'pp_api_menu_css_scripts' ) );
		}

		// Draw option page
		public function pp_api_menu_config_page() {

			$settings_tabs = array(
				$this->activation_tab_key   => __( $this->menu_tab_activation_title, $this->text_domain ),
				$this->deactivation_tab_key => __( $this->menu_tab_deactivation_title, $this->text_domain )
			);
			$current_tab   = isset( $_GET['tab'] ) ? $_GET['tab'] : $this->activation_tab_key;
			$tab           = isset( $_GET['tab'] ) ? $_GET['tab'] : $this->activation_tab_key;
			?>
			<div class='wrap'>
				<?php screen_icon(); ?>
				<h2><?php _e( $this->settings_title, $this->text_domain ); ?></h2>

				<h2 class="nav-tab-wrapper">
					<?php
					foreach ( $settings_tabs as $tab_page => $tab_name ) {
						$active_tab = $current_tab == $tab_page ? 'nav-tab-active' : '';
						echo '<a class="nav-tab ' . $active_tab . '" href="?page=' . $this->activation_tab_key . '&tab=' . $tab_page . '">' . $tab_name . '</a>';
					}
					?>
				</h2>

				<form action='options.php' method='post'>
					<div class="main">
						<?php
						if ( $tab == $this->activation_tab_key ) {
							settings_fields( $this->data_key );
							do_settings_sections( $this->activation_tab_key );
							submit_button( __( 'Save Changes', $this->text_domain ) );
						} else {
							settings_fields( $this->deactivate_checkbox );
							do_settings_sections( $this->deactivation_tab_key );
							submit_button( __( 'Save Changes', $this->text_domain ) );
						}
						?>
					</div>
				</form>
			</div>
		<?php
		}

		// Register settings
		public function pp_api_menu_load_settings() {

			register_setting( $this->data_key, $this->data_key, array( $this, 'pp_api_menu_validate_options' ) );

			// API Key
			add_settings_section( 'api_key', __( 'API License Activation', $this->text_domain ), '__return_false', $this->activation_tab_key );
			add_settings_field( 'status', __( 'API License Key Status', $this->text_domain ), array(
				$this,
				'pp_api_menu_wc_am_api_key_status'
			), $this->activation_tab_key, 'api_key' );
			add_settings_field( 'api_key', __( 'API License Key', $this->text_domain ), array(
				$this,
				'pp_api_menu_wc_am_api_key_field'
			), $this->activation_tab_key, 'api_key' );
			add_settings_field( 'activation_email', __( 'API License email', $this->text_domain ), array(
				$this,
				'pp_api_menu_wc_am_api_email_field'
			), $this->activation_tab_key, 'api_key' );

			// Activation settings
			register_setting( $this->deactivate_checkbox, $this->deactivate_checkbox, array(
				$this,
				'pp_api_menu_wc_am_license_key_deactivation'
			) );
			add_settings_section( 'deactivate_button', __( 'API License Deactivation', $this->text_domain ), '__return_false', $this->deactivation_tab_key );
			add_settings_field( 'deactivate_button', __( 'Deactivate API License Key', $this->text_domain ), array(
				$this,
				'pp_api_menu_wc_am_deactivate_textarea'
			), $this->deactivation_tab_key, 'deactivate_button' );

		}

		// Returns the API License Key status from the WooCommerce API Manager on the server
		public function pp_api_menu_wc_am_api_key_status() {
			$license_status       = $this->pp_api_menu_license_key_status();
			$license_status_check = ( ! empty( $license_status['status_check'] ) && $license_status['status_check'] == 'active' ) ? 'Activated' : 'Deactivated';
			if ( ! empty( $license_status_check ) ) {
				echo $license_status_check;
			}
		}

		// Returns API License text field
		public function pp_api_menu_wc_am_api_key_field() {

			$this->pp_api_menu_wc_am_api_field_render( 'api_key' );

		}

		// Returns API License email text field
		public function pp_api_menu_wc_am_api_email_field() {

			$this->pp_api_menu_wc_am_api_field_render( 'activation_email' );

		}

		/**
		 * @param string $key The key for the field
		 */
		private function pp_api_menu_wc_am_api_field_render( $key ) {

			//Outputting the field
			echo "<input id='$key' name='" . $this->data_key . "[$key]' size='25' type='text' value='" . $this->options[ $key ] . "' />";

			//Adding icon
			if ( $this->options[ $key ] ) {

				echo "<span class='icon-pos'><img src='" . $this->plugin_url() . "pp-api/assets/images/complete.png' title='' style='padding-bottom: 4px; vertical-align: middle; margin-right:3px;' /></span>";

			} else {

				echo "<span class='icon-pos'><img src='" . $this->plugin_url() . "pp-api/assets/images/warn.png' title='' style='padding-bottom: 4px; vertical-align: middle; margin-right:3px;' /></span>";

			}
		}

		// Sanitizes and validates all input and output for Dashboard
		public function pp_api_menu_validate_options( $input ) {

			// Load existing options, validate, and update with changes from input before returning
			$options = $this->options;

			$options[ 'api_key' ]          = trim( $input[ 'api_key' ] );
			$options[ 'activation_email' ] = trim( $input[ 'activation_email' ] );

			/**
			 * Plugin Activation
			 */
			$api_email = trim( $input[ 'activation_email' ] );
			$api_key   = trim( $input['api_key'] );

			$activation_status = get_option( $this->activated_key );
			$checkbox_status   = get_option( $this->deactivate_checkbox );

			$current_api_key = $this->options['api_key'];

			// Should match the settings_fields() value
			if ( $_REQUEST['option_page'] != $this->deactivate_checkbox ) {

				if ( $activation_status == 'Deactivated' || $activation_status == '' || $api_key == '' || $api_email == '' || $checkbox_status == 'on' || $current_api_key != $api_key ) {

					/**
					 * If this is a new key, and an existing key already exists in the database,
					 * deactivate the existing key before activating the new key.
					 */
					if ( $current_api_key != $api_key ) {
						$this->pp_api_menu_replace_license_key( $current_api_key );
					}

					$args = array(
						'email'       => $api_email,
						'licence_key' => $api_key,
					);

					$activate_results = json_decode( $this->key_class->activate( $args ), true );

					if ( $activate_results['activated'] === true ) {
						add_settings_error( 'activate_text', 'activate_msg', __( 'Plugin activated. ', $this->text_domain ) . "{$activate_results['message']}.", 'updated' );
						update_option( $this->activated_key, 'Activated' );
						update_option( $this->deactivate_checkbox, 'off' );
					}

					if ( $activate_results == false ) {
						add_settings_error( 'api_key_check_text', 'api_key_check_error', __( 'Connection failed to the License Key API server. Try again later.', $this->text_domain ), 'error' );
						$options['api_key']                 = '';
						$options[ 'activation_email' ] = '';
						update_option( $this->options[ $this->activated_key ], 'Deactivated' );
					}

					$this->check_error( $activate_results );

				} // End Plugin Activation

			}

			return $options;
		}

		private function check_error( $activate_results ) {

			if ( ! empty( $activate_results['code'] ) ) {

				//Gett error info and set error
				$error_info = pp_api_error_info( $activate_results['code'] );
				add_settings_error( $error_info[0], $error_info[1], "{$activate_results['error']}. {$activate_results['additional info']}", 'error' );

				//Get the options empty
				$options[ 'activation_email' ] = '';
				$options['api_key'] = '';

				//Set activation status Deactivated
				update_option( $this->options[ $this->activated_key ], 'Deactivated' );
			}
		}

		// Returns the API License Key status from the WooCommerce API Manager on the server
		public function pp_api_menu_license_key_status() {
			$activation_status = get_option( $this->activated_key );

			$args = array(
				'email'       => $this->options[ 'activation_email' ],
				'licence_key' => $this->options['api_key'],
			);

			return json_decode( $this->key_class->status( $args ), true );
		}

		// Deactivate the current license key before activating the new license key
		public function pp_api_menu_replace_license_key( $current_api_key ) {

			$args = array(
				'email'       => $this->options[ 'activation_email' ],
				'licence_key' => $current_api_key,
			);

			$reset = $this->key_class->deactivate( $args ); // reset license key activation

			if ( $reset == true ) {
				return true;
			}

			return add_settings_error( 'not_deactivated_text', 'not_deactivated_error', __( 'The license could not be deactivated. Use the License Deactivation tab to manually deactivate the license before activating a new license.', $this->text_domain ), 'updated' );
		}

		// Deactivates the license key to allow key to be used on another blog
		public function pp_api_menu_wc_am_license_key_deactivation( $input ) {

			$activation_status = get_option( $this->activated_key );

			$args = array(
				'email'       => $this->options[ 'activation_email' ],
				'licence_key' => $this->options['api_key'],
			);

			$options = ( $input == 'on' ? 'on' : 'off' );

			if ( $options == 'on' && $activation_status == 'Activated' && $this->options['api_key'] != '' && $this->options[ 'activation_email' ] != '' ) {

				// deactivates license key activation
				$activate_results = json_decode( $this->key_class->deactivate( $args ), true );

				// Used to display results for development
				//print_r($activate_results); exit();

				if ( $activate_results['deactivated'] === true ) {
					$update = array(
						'api_key'               => '',
						'activation_email' => ''
					);

					$merge_options = array_merge( $this->options, $update );

					update_option( $this->data_key, $merge_options );

					update_option( $this->activated_key, 'Deactivated' );

					add_settings_error( 'wc_am_deactivate_text', 'deactivate_msg', __( 'Plugin license deactivated. ', $this->text_domain ) . "{$activate_results['activations_remaining']}.", 'updated' );

					return $options;
				}

				$this->check_error( $activate_results );

			} else {

				return $options;
			}
		}

		public function pp_api_menu_wc_am_deactivate_textarea() {

			echo '<input type="checkbox" id="' . $this->deactivate_checkbox . '" name="' . $this->deactivate_checkbox . '" value="on"';
			echo checked( get_option( $this->deactivate_checkbox ), 'on' );
			echo '/>';
			?><span
				class="description"><?php _e( 'Deactivates an API License Key so it can be used on another blog.', $this->text_domain ); ?></span>
		<?php
		}

		// Loads admin style sheets
		public function pp_api_menu_css_scripts() {

			wp_enqueue_style( $this->data_key . '-css', $this->plugin_url() . 'pp-api/assets/css/admin-settings.css', array(), $this->version, 'all' );

		}
	}
}