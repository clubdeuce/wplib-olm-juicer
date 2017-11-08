<?php

namespace Clubdeuce\WPLib\Components\Juicer\Tests;

use Clubdeuce\WPLib\Components\Juicer;

/**
 * Class testJuicer
 * @package Clubdeuce\WPLib\Components\Juicer\Tests
 *
 * @coversDefaultClass \Clubdeuce\WPLib\Components\Juicer
 */
class testJuicer extends TestCase {

	/**
	 * @covers ::_url_params
	 */
	public function testEnsureUrlParamsReturnsString() {

		$params = $this->reflectionMethodInvokeArgs(
			'\Clubdeuce\WPLib\Components\Juicer', '_url_params', array('foo' => 'bar', 'foobar' => 'foobaz')
		);

		$this->assertInternalType('string', $params);

	}

	/**
	 * @covers ::_url_params
	 * @depends testEnsureUrlParamsReturnsString
	 */
	public function testEnsureUrlParams() {

		$params = $this->reflectionMethodInvokeArgs(
			'\Clubdeuce\WPLib\Components\Juicer', '_url_params', array('foo' => 'bar', 'foobar' => 'foobaz')
		);

		$this->assertEquals(
			'foo=bar&foobar=foobaz',
			$params
		);

	}

}
