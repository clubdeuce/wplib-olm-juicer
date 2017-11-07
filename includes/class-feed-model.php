<?php
namespace Clubdeuce\WPLib\Components\Juicer;

/**
 * Class Feed_Model
 * @package Clubdeuce\WPLib\Components\Modules\Juicer
 * @link https://www.juicer.io/api
 *
 * @method string        id()
 * @method string        slug()
 * @method string        name()
 * @method string        plan()
 * @method int           update_frequency()
 * @method string        last_synced()
 * @method integer       max_sources()
 * @method string        more_sources_allowed()
 * @method bool          analytics_allowed()
 * @method bool          moderation_allowed()
 * @method string        css()
 * @method int           interval()
 * @method int           width()
 * @method int           height()
 * @method int           columns()
 * @method string        order()
 * @method string        display_filter()
 * @method bool          display_filter_type()
 * @method bool          colored_icons()
 * @method bool          photos()
 * @method bool          videos()
 * @method bool          lazy_load()
 * @method bool          overlay()
 * @method bool          infinite_scroll()
 * @method bool          poll()
 * @method string        disallowed()
 * @method string        allowed()
 * @method int           distance()
 * @method string        location()
 * @method float         lat()
 * @method float         lng()
 * @method bool          profanity()
 * @method bool          prevent_duplicates()
 * @method bool          queue()
 * @method bool          moderating()
 * @method int           page_views_count()
 * @method string        custom_css()
 * @method \stdClass     colors()
 * @method array         social_accounts()
 */
class Feed_Model extends \WPLib_Model_Base {

    /**
     * @var \stdClass
     */
    protected $_response;

    /**
     * @var Post[]
     */
    protected $_posts;

    /**
     * @var Source[]
     */
    protected $_sources;

    /**
     * @return bool
     */
    function has_feed() {

        $has = false;

        do {
            if ( empty( $this->_response() ) ) {
                break;
            }

            if ( is_wp_error( $response = $this->_response() ) ) {
                break;
            }

            $has = true;
        } while ( false );


        return $has;

    }

    /**
     * @return Post[]
     */
    function posts() {

        $posts = array();

        do {

            $response = $this->_response();

            if ( ! isset( $response->posts->items ) ) {
                break;
            }

            foreach ($this->_response()->posts->items as $post ) {
                $this->_posts[] = new Post( array( 'post' => $post ) );
            }

            $posts = $this->_posts;
        } while ( false );

        return $posts;

    }

    /**
     * @return Source[]
     */
    function sources() {

        do {

        	if ( ! empty( $this->_sources ) ) {
        		$sources = $this->_sources;
        		break;
	        }

            foreach( $this->_response()->sources as $source ) {
                $this->_sources[] = new Source( array( 'source_object' => $source ) );
            }

            $sources = $this->_sources;

        } while ( false );

        return $sources;

    }

    /**
     * @param  string $method_name
     * @param  array $args
     * @return null|mixed
     */
    function __call( $method_name, $args = array() ) {

        do {

            $maybe = $this->_response()->{$method_name};

            if ( isset( $maybe ) ) {
                $value = $maybe;
                break;
            }

            $value = null;
        } while ( false );

        return $value;

    }

    /**
     * @param  string $property
     * @return string
     */
    function __get( $property ) {

        return '';

    }

    /**
     * @return \stdClass
     */
    protected function _response() {

        return $this->_response;

    }

}
