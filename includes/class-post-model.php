<?php
namespace Clubdeuce\WPLib\Components\Juicer;

/**
 * Class Post_Model
 * @package Clubduece\WPLib\Components\Juicer
 * @link    https://www.juicer.io/api#post
 *
 * @method int    id()
 * @method string external_id()
 * @method string external_created_at()
 * @method string full_url()
 * @method string image()
 * @method string external()
 * @method int    like_count()
 * @method int    comment_count()
 * @method string tagged_users()
 * @method string poster_url()
 * @method string poster_id()
 * @method string location()
 * @method int    height()
 * @method int    width()
 * @method string edit()
 * @method int    position()
 * @method string deleted_at()
 * @method string deleted_by()
 * @method string message()
 * @method string unformatted_message()
 * @method string description()
 * @method string feed()
 * @method string likes()
 * @method string comments()
 * @method string video()
 * @method string poster_image()
 * @method string poster_name()
 */
class Post_Model extends \WPLib_Model_Base {

    /**
     * The post response object
     *
     * @var \StdClass
     */
    protected $_post;

    /**
     * @return bool
     */
    function has_post() {

        $has = false;

        if ( isset( $this->_post ) ) {
            $has = true;
        }

        return $has;

    }

    /**
     * An alias for the external_created_at property
     *
     * @return string
     */
    function timestamp() {

        return $this->external_created_at();

    }

    /**
     * @return Source
     */
    function source() {

        $source = new Source();

        if ( isset( $this->_post->source ) ) {
            $source = new Source( array( 'source_object' => $this->_post->source ) );
        }

        return $source;

    }

    /**
     * @param  string $method_name
     * @param  array $args
     * @return mixed|null
     */
    function __call( $method_name, $args ) {

        $value = null;

        do {
            if ( ! $this->has_post() ) {
                break;
            }

            if ( isset( $this->_post->{$method_name} ) ) {
                $value = $this->_post->{$method_name};
                break;
            }

        } while ( false );

        return $value;

    }

}