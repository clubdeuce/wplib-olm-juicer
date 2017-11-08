<?php

namespace Clubdeuce\WPLib\Components\Juicer\Tests\Integration;

use Clubdeuce\WPLib\Components\Juicer;
use Clubdeuce\WPLib\Components\Juicer\Tests\TestCase;

/**
 * Class testJuicer
 * @package Clubdeuce\WPLib\Components\Juicer\Tests
 *
 * @coversDefaultClass \Clubdeuce\WPLib\Components\Juicer
 * @group              Integration
 */
class testJuicer extends TestCase {

	/**
	 * @covers ::get_feed
	 */
	public function testGetFeedReturnsFeedObject() {

		$this->assertInstanceOf(
			'\Clubdeuce\WPLib\Components\Juicer\Feed',
			Juicer::get_feed(array('feed' => 'mytestfeed-362c6099-dcfa-4214-a907-1a49d65f3012'), 'http')
		);

	}

	/**
	 * @covers ::_make_request
	 */
	public function testMakeRequestReturnsStdClass() {

		$this->assertInstanceOf(
			'\stdClass',
			$this->reflectionMethodInvokeArgs(
				'\Clubdeuce\WPLib\Components\Juicer',
				'_make_request',
				'http://www.juicer.io/api/feeds/mytestfeed-362c6099-dcfa-4214-a907-1a49d65f3012'
			)
		);

	}

	/**
	 * @covers ::_make_request
	 */
	public function testMakeRequestInvalidURL() {

		$this->assertInstanceOf(
			'\WP_Error',
			$this->reflectionMethodInvokeArgs(
				'\Clubdeuce\WPLib\Components\Juicer',
				'_make_request',
				'asdf'
			)
		);

	}

	/**
	 * #covers ::_make_request
	 */
	public function testMakeRequestNonexistentURL() {

		$this->assertInstanceOf(
			'\WP_Error',
			$this->reflectionMethodInvokeArgs(
				'\Clubdeuce\WPLib\Components\Juicer',
				'_make_request',
				'https://foo.bar'
			)
		);

	}

	/**
	 * @covers ::_make_request
	 */
	public function testMakeRequestWith404() {

		$this->assertInstanceOf(
			'\WP_Error',
			$this->reflectionMethodInvokeArgs(
				'\Clubdeuce\WPLib\Components\Juicer',
				'_make_request',
				'http://www.juicer.io/api/asdfasdfsadf'
			)
		);

	}

}
