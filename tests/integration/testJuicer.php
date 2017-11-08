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

}
