<?php

namespace Clubdeuce\WPLib\Components\Juicer\Tests;

use Clubdeuce\WPLib\Components\Juicer\Post_Model;

/**
 * Class testPostModel
 * @package Clubdeuce\WPLib\Components\Juicer\Tests
 *
 * @coversDefaultClass \Clubdeuce\WPLib\Components\Juicer\Post_Model
 */
class testPostModel extends TestCase {

	/**
	 * @var Post_Model;
	 */
	private $_model;

	/**
	 *
	 */
	public function setUp() {

		$this->_model = new Post_Model();
		$this->_model->set_state(array('post' => $this->_get_sample_response()->posts->items[0]));
		parent::setUp();

	}

	/**
	 * @covers ::has_post
	 */
	public function testHasPostFalse() {

		$post = new Post_Model();
		$this->assertFalse($post->has_post());

	}

	/**
	 * @covers ::has_post
	 */
	public function testHasPostTrue() {

		$this->assertTrue($this->_model->has_post());

	}

	/**
	 * @covers ::__call
	 */
	public function testCall() {

		$this->assertEquals(175399104, $this->_model->id());

	}

	/**
	 * @covers  ::__call
	 * @depends testHasPostFalse
	 */
	public function testCallFail() {

		$model = new Post_Model();

		$this->assertNull($model->id());

	}

	/**
	 * @covers  ::timestamp
	 * @depends testCall
	 */
	public function testTimestampReturnsString() {

		$this->assertInternalType('string', $this->_model->timestamp());

	}

	/**
	 * @covers  ::timestamp
	 * @depends testTimestampReturnsString
	 */
	public function testTimestamp() {

		$this->assertEquals('2017-11-07T08:04:24.000-08:00', $this->_model->timestamp());

	}

	/**
	 * @covers ::source
	 */
	public function testSourceReturnsSourceObject() {

		$this->assertInstanceOf('\Clubdeuce\WPLib\Components\Juicer\Source', $this->_model->source());

	}

}