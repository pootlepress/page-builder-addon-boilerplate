<?php
/**
 * Created by shramee
 * At: 9:04 PM 14/8/15
 */

/**
 * Output the error info from code
 *
 * @param int $code The error code
 *
 * @return array|bool Error info or false
 */
function pp_api_error_info( $code ) {
	switch ( $code ) {
		case '100':
			return array( 'api_email_text', 'api_email_error' );
		case '101':
			return array( 'api_key_text', 'api_key_error' );
		case '102':
			return array( 'api_key_purchase_incomplete_text', 'api_key_purchase_incomplete_error' );
		case '103':
			return array( 'api_key_exceeded_text', 'api_key_exceeded_error' );
		case '104':
			return array( 'api_key_not_activated_text', 'api_key_not_activated_error' );
		case '105':
			return array( 'api_key_invalid_text', 'api_key_invalid_error' );
		case '106':
			return array( 'sub_not_active_text', 'sub_not_active_error' );
		default:
			return false;
	}

}
