<?php

namespace Clubdeuce\WPLib\Components\Juicer\Tests\Integration;

use Clubdeuce\WPLib\Components\Juicer\Post;
use Clubdeuce\WPLib\Components\Juicer\Tests\TestCase;

/**
 * Class testPost
 * @package Clubdeuce\WPLib\Components\Juicer\Tests\Integration
 *
 * @group Integration
 * @group Post
 */
class testPost extends TestCase {

	/**
	 * @var Post;
	 */
	private $_post;

	/**
	 *
	 */
	public function setUp() {

		$this->_post = new Post(array('post' => $this->_get_sample_response()->posts->items[0]));
		parent::setUp();

	}

	/**
	 * @covers \Clubdeuce\WPLib\Components\Juicer\Post_View::the_timestamp
	 */
	public function testTheTimestamp() {

		$this->expectOutputString('Nov 07, 2017');
		$this->_post->the_timestamp();

	}

	/**
	 * @covers \Clubdeuce\WPLib\Components\Juicer\Post_View::the_message
	 */
	public function testTheMessage() {

		$this->expectOutputString('<p>Now showing at Ensworth High School is <a href=\'https://twitter.com/claudoverstreet\' target=\'_blank\'>@claudoverstreet</a>\'s beautiful new show "Time Pieces." Check it out. </p>');
		$this->_post->the_message();

	}

	/**
	 * @covers \Clubdeuce\WPLib\Components\Juicer\Post_View::_download_image()
	 */
	public function testDownloadImage() {

		$this->assertEquals(
			'/tmp/5d055301868e4e170e4f1f4dc935b98e',
			$this->reflectionMethodInvokeArgs( $this->_post->view(), '_download_image', $this->_post->image())
		);

	}

	/**
	 * @covers \Clubdeuce\WPLib\Components\Juicer\Post_View::_download_image()
	 */
	public function testDownloadImageBadURL() {

		$response = $this->reflectionMethodInvokeArgs( $this->_post->view(), '_download_image', 'asdf');
		$this->assertEmpty($response);

	}

	/**
	 * @covers \Clubdeuce\WPLib\Components\Juicer\Post_View::_download_image()
	 */
	public function testDownloadImage404() {

		$response = $this->reflectionMethodInvokeArgs( $this->_post->view(), '_download_image', 'http://google.com/asdf');
		$this->assertEmpty($response);

	}

	/**
	 * @covers \Clubdeuce\WPLib\Components\Juicer\Post_View::the_image_url()
	 */
	public function testTheImageUrlNoResize() {

		$this->expectOutputString('https://pbs.twimg.com/media/DOCrFSDUEAEAxaW.jpg');
		$this->_post->the_image_url();

	}

}
