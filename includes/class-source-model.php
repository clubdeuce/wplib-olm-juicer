<?php

namespace Clubdeuce\WPLib\Components\Juicer;

/**
 * Class Source_Model
 * @package Clubdeuce\WPLib\Components\Juicer
 *
 * @method int    id()
 * @method string term()
 * @method string term_type()
 * @method string source()
 * @method string options()
 *
 */
class Source_Model extends \WPLib_Model_Base {

    /**
     * @var \stdClass
     */
    protected $_source_object;

    /**
     * @param  string $method_name
     * @param  array $args
     * @return mixed|null
     */
    function __call( $method_name, $args = array() ) {

        do {

            $property = "_{$method_name}";

            if ( property_exists( __CLASS__, $method_name ) ) {
                $value = $this->{$property};
                break;
            }

            if ( isset( $this->source_object()->{$method_name} ) ) {
                $value = $this->source_object()->{$method_name};
                break;
            }

            $value = null;
        } while ( false );

        return $value;

    }

    /**
     * @return \stdClass
     */
    protected function source_object() {

        return $this->_source_object;

    }

}