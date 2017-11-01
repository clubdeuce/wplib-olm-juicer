<?php
namespace Clubdeuce\WPLib\Components\Juicer;

/**
 * Class Post_View
 * @package Clubdeuce\WPLib\Components\Juicer
 *
 * @property Post_Model $model
 * @method   Post_Model model()
 */
class Post_View extends \WPLib_View_Base {

    /**
     * @param int  $maxw
     * @param int  $maxh
     * @param bool $crop
     */
    function the_image_url( $maxw = null, $maxh = null, $crop = false ) {

        $url = '';

        do {

            // Is this a valid URL?
            if ( ! wp_http_validate_url( esc_url( $this->model()->image() ) ) ) {
                break;
            }

            $url = $this->model()->image();

            // Do we need to resize it?
            if ( is_null( $maxh ) && is_null( $maxw ) ) {
                break;
            }

            // generate a unique filename for this image with the specified dimensions
            $fileargs = array(
                basename( $url ),
                $maxh,
                $maxw,
                $crop,
            );

            $filename = md5( implode( ',', $fileargs ) );

            $path = WP_CONTENT_DIR . '/uploads/juicer/cache/' . $filename;

            // get the file extension
            $extension = '';
            if ( preg_match( '#^http[s]{0,1}://.*?\.([a-zA-Z0-9]{3,4})$#', $url, $matches ) ) {
                $extension = $matches[1];
            }

            // Does the file already exist?
            if ( file_exists( $path . '.' . $extension ) ) {
                $url = sprintf( '%1$s/uploads/juicer/cache/%2$s.%3$s', WP_CONTENT_URL, $filename, $extension );
                break;
            }

            $response = wp_remote_get( $url );

            if ( $response instanceof \WP_Error){
                break;
            }

            // Was the download successful?
            if ( ! ( 200 === wp_remote_retrieve_response_code( $response ) ) ) {
                break;
            }

            // store it temporarily
            $tmpfile = sprintf( '/tmp/%1$s', md5( $url ) );

            if ( ! file_put_contents( $tmpfile, wp_remote_retrieve_body( $response ) ) ) {
                break;
            }

            // Get an image editor object
            $editor = wp_get_image_editor( $tmpfile );

            // can we edit this image file?
            if (  $editor instanceof \WP_Error) {
                break;
            }

            // then resize to the dimensions specified
            $result = $editor->resize( $maxw, $maxh, $crop );


            if ( ! $result || $result instanceof \WP_Error ) {
                break;
            }

            // make sure we have a cache directory
            if ( ! is_dir( WP_CONTENT_DIR . '/uploads/juicer/cache/' ) ) {
                if ( ! mkdir( WP_CONTENT_DIR . '/uploads/juicer/cache/', 0775, true  ) ) {
                    break;
                }
            }

            // and then save the modified image
            $result = $editor->save( $path );

            if ( $result instanceof \WP_Error) {
                break;
            }

            $url = WP_CONTENT_URL . '/uploads/juicer/cache/' . $result['file'];

        } while ( false );

        echo esc_url( $url );

    }

    function the_message() {

        echo wp_kses_post( $this->model()->message() );

    }

    /**
     * @param string $format
     */
    function the_timestamp( $format = 'M d, Y' ) {

        echo date( $format, strtotime( $this->model()->timestamp() ) );

    }

}
