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
            $api_url = sprintf( '%1$s/feeds/%2$s?%3$s', self::$_base_url, $args['feed'], implode( '&', $params ) );

            $response = self::_make_request( $api_url );

            if ( ! is_object( $response ) ) {
                break;
            }

            if ( is_wp_error( $response ) ) {
                self::trigger_error(
                    sprintf(
                        'Juicer error requesting %1$s: %2$s',
                        $api_url,
                        $response->get_error_message()
                    )
                );
            }

            $class = self::INSTANCE_CLASS;
            $feed = new $class( array( 'response' => $response ) );

        } while ( false );

        return $feed;

    }

    /**
     * @param array $args
     * @return array
     */
    protected static function _url_params( $args = array() ) {

        $params = array();

        do {
            if ( ! is_array( $args ) ) {
                break;
            }

            if ( empty( $args ) ) {
                break;
            }

            foreach ( array_filter( $args ) as $key => $val ) {
                $params[] = sprintf( '%1$s=%2$s', $key, $val );
            }

        } while ( false );

        return $params;

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

            if ( is_wp_error( $fetch ) ) {
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

            $response = json_decode( wp_remote_retrieve_body( $fetch ) );

            wp_cache_set( $cache_key, $response, 'juicer', 600 );
        } while ( false );

        return $response;

    }

}