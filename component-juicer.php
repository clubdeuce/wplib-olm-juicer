<?php

namespace Clubdeuce\WPLib\Components;

use Clubdeuce\WPLib\Components\Juicer\Feed;

/**
 * Class Juicer
 * @package Clubdeuce\WPLib\Components
 */
class Juicer extends \WPLib_Module_Base {

    const INSTANCE_CLASS = '\Clubdeuce\WPLib\Components\Juicer\Feed';

    /**
     * The base API URL
     *
     * @var string
     */
    protected static $_base_url = 'https://www.juicer.io/api';

    /**
     * @param  array $args
     * @return Feed
     */
    static function get_feed( $args = array() ) {

        $feed = null;
        $args = wp_parse_args( $args, array(
            'feed'   => null,
            'per'    => '100',
            'page'   => '1',
            'filter' => '',
            'starting_at' => '',
            'ending_at'   => '',
        ) );

        do {
            $params  =  self::_url_params( $args );
            $api_url = sprintf( '%1$s/feeds/%2$s?%3$s', self::$_base_url, $args['feed'], $params );

            $response = self::_make_request( $api_url );

            if ( $response instanceof \WP_Error ) {
                trigger_error( sprintf(
                    'Juicer error requesting %1$s: %3$s %2$s',
                    $api_url,
                    $response->get_error_message(),
                    $response->get_error_code()
                ), E_USER_WARNING );
                $response = array();
            }

            $class = self::INSTANCE_CLASS;
            $feed = new $class( array( 'response' => $response ) );

        } while ( false );

        return $feed;

    }

    /**
     * @param  array $args
     * @return string
     */
    protected static function _url_params( $args = array() ) {

        $params = array();

	    $args = wp_parse_args( $args );

        foreach ( array_filter( $args ) as $key => $val ) {
            $params[] = sprintf( '%1$s=%2$s', $key, $val );
        }

        return implode( '&', $params );

    }

    /**
     * @param  $url
     * @return \stdClass|\WP_Error
     */
    protected static function _make_request( $url ) {

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