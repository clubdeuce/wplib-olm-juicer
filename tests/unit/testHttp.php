<?php

namespace Clubdeuce\WPLib\Components\Juicer\Tests;
use Clubdeuce\WPLib\Components\Juicer\HTTP;

/**
 * Class testHttp
 * @package Clubdeuce\WPLib\Components\Juicer\Tests
 *
 * @coversDefaultClass Clubdeuce\WPLib\Components\Juicer\HTTP
 */
class testHttp extends TestCase {

	/**
	 * @var HTTP
	 */
	private $_http;

	public function setUp() {

		$this->_http = new HTTP();

	}

	/**
	 * @covers ::fetch
	 */
	public function testMakeRequestReturnsStdClass() {

		$this->assertInstanceOf(
			'\stdClass',
			$this->_http->fetch('http://www.juicer.io/api/feeds/mytestfeed-362c6099-dcfa-4214-a907-1a49d65f3012')
		);

	}

	/**
	 * @covers ::fetch
	 */
	public function testMakeRequestInvalidURL() {

		$this->assertInstanceOf(
			'\WP_Error',
			$this->_http->fetch('asdf')
		);

	}

	/**
	 * #covers ::fetch
	 */
	public function testMakeRequestNonexistentURL() {

		$this->assertInstanceOf(
			'\WP_Error',
			$this->_http->fetch('https://foo.bar')
		);

	}

	/**
	 * @covers ::fetch
	 */
	public function testMakeRequestWith404() {

		$this->assertInstanceOf(
			'\WP_Error',
			$this->_http->fetch('http://www.juicer.io/api/asdfasdfsadf')
		);

	}

}
