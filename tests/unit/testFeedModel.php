<?php

namespace Clubdeuce\WPLib\Components\Juicer\Tests;

use Clubdeuce\WPLib\Components\Juicer\Feed_Model;

/**
 * Class testFeedModel
 * @package Clubdeuce\WPLib\Components\Juicer\Tests
 *
 * @coversDefaultClass \Clubdeuce\WPLib\Components\Juicer\Feed_Model
 */
class testFeedModel extends TestCase {

	/**
	 * @var Feed_Model;
	 */
	private $_model;

	public function setUp() {

		$this->_model = new Feed_Model();
		$this->_model->set_state(array('response' => $this->_get_sample_response()));
		parent::setUp();

	}

	/**
	 * @covers ::has_feed
	 */
	public function testHasFeedFalse() {

		$feed = new Feed_Model();

		$this->assertFalse($feed->has_feed());

	}

	/**
	 * @covers ::has_feed
	 */
	public function testHasFeedWPError() {

		$feed = new Feed_Model(array('response' => new \WP_Error()));

		$this->assertFalse($feed->has_feed());

	}

	/**
	 * @covers ::has_feed
	 */
	public function testHasFeedTrue() {

		$this->assertTrue($this->_model->has_feed());

	}

	/**
	 * @covers  ::_response
	 * @depends testHasFeedTrue
	 */
	public function testResponse() {

		$this->assertEquals(
			$this->_get_sample_response(),
			$this->reflectionMethodInvoke( $this->_model, '_response')
		);

	}

	/**
	 * @covers  ::posts
	 * @depends testHasFeedTrue
	 */
	public function testPostsIsArray() {

		$this->assertInternalType('array', $this->_model->posts());

	}

	/**
	 * @covers ::posts
	 */
	public function testPostsEmpty() {

		$feed = new Feed_Model(array('response' => array()));

		$this->assertEmpty($feed->posts());

	}

	/**
	 * @covers  ::posts
	 * @depends testPostsIsArray
	 */
	public function testPostsNotEmpty() {

		$this->assertNotEmpty( $this->_model->posts() );

	}

	/**
	 * @covers  ::posts
	 * @depends testPostsNotEmpty
	 */
	public function testPostsCount() {

		$this->assertEquals(100, count($this->_model->posts()));

	}

	/**
	 * @covers  ::posts
	 * @depends testPostsCount
	 */
	public function testPostsReturnsPostObject() {

		$this->assertInstanceOf('\Clubdeuce\WPLib\Components\Juicer\Post', $this->_model->posts()[0] );

	}

	/**
	 * @covers  ::sources
	 * @depends testHasFeedTrue
	 */
	public function testSourcesIsArray() {

		$this->assertInternalType('array', $this->_model->sources());

	}

	/**
	 * @covers  ::sources
	 * @depends testSourcesIsArray
	 */
	public function testSourcesNotEmpty() {

		$this->assertNotEmpty($this->_model->sources());

	}

	/**
	 * @covers  ::sources
	 * @depends testSourcesNotEmpty
	 */
	public function testSourcesCount() {

		$this->assertEquals(3, count($this->_model->sources()));

	}

	/**
	 * @covers  ::sources
	 * @depends testSourcesNotEmpty
	 */
	public function testSourcesReturnsSourceObject() {

		$this->assertInstanceOf('\Clubdeuce\WPLib\Components\Juicer\Source', $this->_model->sources()[0] );

	}

	/**
	 * @covers ::sources
	 */
	public function testSourcesWhenSet() {

		$this->_model->sources();

		$this->assertNotEmpty( $this->_model->sources());

	}

	/**
	 * @covers ::__call
	 */
	public function testCall() {

		$this->assertEquals(63321, $this->_model->id());

	}

	/**
	 * @covers ::__call
	 */
	public function testCallNoProperty() {

		$this->assertNull($this->_model->foo());

	}

	/**
	 * @covers ::__get
	 */
	public function testGetEmptyString() {

		$this->assertEmpty($this->_model->foo);

	}

}
