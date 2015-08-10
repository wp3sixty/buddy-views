<?php

if ( ! function_exists( 'buddy_views_is_request' ) ) {
	/**
	 * What type of request is this?
	 * @param $type
	 *
	 * @return bool
	 */
	function buddy_views_is_request( $type ) {
		switch ( $type ) {
			case 'admin' :
				return is_admin();
			case 'ajax' :
				return defined( 'DOING_AJAX' );
			case 'cron' :
				return defined( 'DOING_CRON' );
			case 'frontend' :
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}
}

if ( ! function_exists( 'buddy_views_setcookie' ) ) {

	/**
	 * @param $name
	 * @param $value
	 * @param int $expire
	 * @param bool|false $secure
	 */
	function buddy_views_setcookie( $name, $value, $expire = 0, $secure = false ) {
		if ( ! headers_sent() ) {
			setcookie( $name, $value, $expire, COOKIEPATH, COOKIE_DOMAIN, $secure );
		} else {
			trigger_error( "{$name} cookie cannot be set - headers already sent", E_USER_NOTICE );
		}
	}
}

