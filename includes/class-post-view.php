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

            // Do we need to resize it?
            if ( is_null( $maxh ) && is_null( $maxw ) ) {
                break;
            }

            $image = $this->_resize_image( $this->model()->image(), $maxw, $maxh, $crop );

            $url = str_replace( WP_CONTENT_DIR, WP_CONTENT_URL, $image );

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

	/**
	 * @param  string   $url
	 * @param  int|null $width
	 * @param  int|null $height
	 * @param  bool     $crop
	 * @return string   the file path
	 */
    private function _resize_image( $url, $width = null, $height = null, $crop = false ) {

	    // generate a unique filename for this image with the specified dimensions
	    $fileargs = array(
		    basename( $url ),
		    $width,
		    $height,
		    $crop,
	    );

	    $filename = md5( implode( ',', $fileargs ) );

	    do {
		    $path = WP_CONTENT_DIR . '/uploads/juicer/cache/' . $filename;

		    // get the file extension
		    $extension = '';
		    if ( preg_match( '#^http[s]{0,1}://.*?\.([a-zA-Z0-9]{3,4})$#', $url, $matches ) ) {
			    $extension = $matches[1];
		    }

		    // Does the file already exist?
		    if ( file_exists( $maybe = $path . '.' . $extension ) ) {
		    	$path = $maybe;
			    break;
		    }

		    $tmpfile = $this->_download_image( $url );

		    // Get an image editor object
		    $editor = wp_get_image_editor( $tmpfile );

		    // can we edit this image file?
		    if (  $editor instanceof \WP_Error) {
			    break;
		    }

		    // then resize to the dimensions specified
		    $result = $editor->resize( $width, $height, $crop );


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

		    $path = $result['path'];
	    } while ( false );

	    return $path;

    }

	/**
	 * @param  string $url
	 *
	 * @return string The location of the downloaded image file
	 */
    private function _download_image( $url ) {

    	$filepath = '';

	    do {
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

		    $filepath = $tmpfile;
	    } while ( false );

	    return $filepath;

    }

}
