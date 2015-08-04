<?php
/**
 * BuddyView Core Functions
 *
 * General core functions available on both the front-end and admin.
 *
 * @author        paresh
 * @category    Core
 * @package    BuddyView/Functions
 * @version     1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Set a cookie - wrapper for setcookie using WP constants
 *
 * @param  string $name Name of the cookie being set
 * @param  string $value Value of the cookie
 * @param  integer $expire Expiry of the cookie
 * @param  string $secure Whether the cookie should be served only over https
 */
function bbv_setcookie( $name, $value, $expire = 0, $secure = false ) {
	if ( ! headers_sent() ) {
		setcookie( $name, $value, $expire, COOKIEPATH, COOKIE_DOMAIN, $secure );
	} elseif ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		headers_sent( $file, $line );
		trigger_error( "{$name} cookie cannot be set - headers already sent by {$file} on line {$line}", E_USER_NOTICE );
	}
}
