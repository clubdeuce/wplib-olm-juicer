<?php

namespace Clubdeuce\WPLib\Components\Juicer\Tests;

/**
 * Class TestCase
 * @package Clubdeuce\WPLib\Components\Juicer\Tests
 */
class TestCase extends \WP_UnitTestCase {

	/**
	 * @param $class
	 * @param $property
	 * @return mixed
	 */
	public function getReflectionPropertyValue( $class, $property )
	{
		$reflection = new \ReflectionProperty( $class, $property );
		$reflection->setAccessible( true );
		return $reflection->getValue( $class );
	}

	/**
	 * @param $class
	 * @param $property
	 * @param $value
	 */
	public function setReflectionPropertyValue( $class, $property, $value )
	{
		$reflection = new \ReflectionProperty( $class, $property );
		$reflection->setAccessible( true );
		return $reflection->setValue( $class, $value );
	}

	/**
	 * @param $class
	 * @param $method
	 * @return mixed
	 */
	public function reflectionMethodInvoke( $class, $method )
	{
		$reflection = new \ReflectionMethod( $class, $method );
		$reflection->setAccessible( true );
		if (is_string($class)) {
			$class = null;
		}
		return $reflection->invoke( $class );
	}

	/**
	 * @param $class
	 * @param $method
	 * @param $args
	 * @return mixed
	 */
	public function reflectionMethodInvokeArgs( $class, $method, $args )
	{
		$reflection = new \ReflectionMethod( $class, $method );
		$reflection->setAccessible( true );
		if (is_string($class)) {
			$class = null;
		}
		return $reflection->invoke( $class, $args );
	}

	/**
	 * @return object
	 */
	protected function _get_sample_response() {

		$response = new \stdClass();

		if(file_exists( $file = TEST_INCLUDES_DIR . '/sample.json')) {
			$response = json_decode(file_get_contents( $file));
		}

		return $response;
	}

}
