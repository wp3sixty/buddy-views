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

if ( ! function_exists( 'buddy_views_getcookie' ) ) {

	/**
	 * @param $name
	 *
	 * @return null
	 */
	function buddy_views_getcookie( $name ) {
		if ( ! empty( $_COOKIE[ $name ] ) ) {
			return $_COOKIE[ $name ];
		}
		return null;
	}

}

if ( ! function_exists( 'buddy_views_get_user_ip' ) ) {

	/**
	 * @return null
	 */
	function buddy_views_get_user_ip () {

		if ( ! empty( $_SERVER['SERVER_ADDR'] ) ) {
			return $_SERVER['SERVER_ADDR'];
		}
		return null;

	}

}

if ( ! function_exists( 'buddy_views_compare_timestamp' ) ) {

	/**
	 * @param $compare_timestamp
	 * @param bool|false $current_timestamp
	 *
	 * @return bool
	 */
	function buddy_views_compare_timestamp ( $compare_timestamp, $current_timestamp = false ) {

		if ( ! $current_timestamp ) {
			$current_timestamp = current_time( 'timestamp' );
		}

		if ( ( $current_timestamp - $compare_timestamp ) > 24 * 60 * 60 ) {
			return false;
		}

		return true;
	}

}

