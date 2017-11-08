<?php

namespace Clubdeuce\WPLib\Components\Juicer\Tests;

use Mockery;
use Clubdeuce\WPLib\Components\Juicer;


/**
 * Class testJuicer
 * @package Clubdeuce\WPLib\Components\Juicer\Tests
 *
 * @coversDefaultClass \Clubdeuce\WPLib\Components\Juicer
 * @group Juicer
 * @group Unit
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

	/**
	 * @covers ::get_feed
	 */
	public function testGetFeedWithError() {

		$mock = Mockery::mock('\Clubdeuce\WPLib\Components\Juicer\HTTP');
		$mock->/** @scrutinizer ignore-call */
			shouldReceive('fetch')->andReturn(new \WP_Error());

		$this->assertInstanceOf(
			'\Clubdeuce\WPLib\Components\Juicer\Feed',
			@Juicer::get_feed(array('feed' => 'asdf', 'transport' => $mock), 'http')
		);

	}

	/**
	 * @covers ::get_feed
	 */
	public function testGetFeed() {

		$mock = Mockery::mock('\Clubdeuce\WPLib\Components\Juicer\HTTP');
		$mock->/** @scrutinizer ignore-call */
			shouldReceive('fetch')->andReturn($this->_get_sample_response());

		$this->assertInstanceOf(
			'\Clubdeuce\WPLib\Components\Juicer\Feed',
			Juicer::get_feed(array('feed' => 'asdf', 'transport' => $mock), 'http')
		);

	}
}
