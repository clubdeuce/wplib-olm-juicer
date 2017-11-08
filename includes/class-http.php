<?php

namespace Clubdeuce\WPLib\Components\Juicer;

/**
 * Class HTTP
 * @package Clubdeuce\WPLib\Components\Juicer
 */
class HTTP {


	/**
	 * @param  $url
	 * @return \stdClass|\WP_Error
	 */
	function fetch( $url ) {

		do {
			if ( ! wp_http_validate_url( $url ) ) {
				$response = new \WP_Error( '100', __( 'Invalid URL', 'cdjuicer' ), array( 'url' => $url ) );
				break;
			}

			if ( $data = wp_cache_get( $cache_key = md5( $url ) ) ) {
				$response = $data;
				break;
			}

			$fetch = wp_remote_get( $url );

			if ( $fetch instanceof \WP_Error ) {
				$response = $fetch;
				break;
			}

			if ( ! ( 200 === wp_remote_retrieve_response_code( $fetch ) ) ) {
				$response = new \WP_Error(
					wp_remote_retrieve_response_code( $fetch ),
					__( 'Unsuccessful request', 'cdjuicer' ),
					wp_remote_retrieve_body( $fetch )
				);
				break;
			}

			$response = wp_remote_retrieve_body( $fetch );

			wp_cache_set( $cache_key, $response, 'juicer', 600 );

			$response = json_decode( $response );
		} while ( false );

		return $response;

	}
}