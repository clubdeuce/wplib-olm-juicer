<?php

namespace Clubdeuce\WPLib\Components;

use Clubdeuce\WPLib\Components\Juicer\Feed;
use Clubdeuce\WPLib\Components\Juicer\HTTP;

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
    protected static $_base_url = 'www.juicer.io/api';

    /**
     * @param  array  $args
     * @param  string $scheme
     * @return Feed
     */
    static function get_feed( $args = array(), $scheme = 'https' ) {

        $args = wp_parse_args( $args, array(
            'feed'        => null,
            'per'         => '100',
            'page'        => '1',
            'filter'      => '',
            'starting_at' => '',
            'ending_at'   => '',
	        'transport'   => new HTTP()
        ) );

	    /**
	     * @var HTTP $http
	     */
	    $http     = $args['transport'];
	    $feedname = $args['feed'];

	    unset( $args['transport'] );
	    unset( $args['feed'] );

        $api_url = sprintf( '%1$s://%2$s/feeds/%3$s?%4$s', $scheme, self::$_base_url, $feedname, self::_url_params( $args ) );

        $response = $http->fetch( $api_url );

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


}