<?php

namespace Clubdeuce\WPLib\Components\Juicer\Tests;

use Clubdeuce\WPLib\Components\Juicer\Source_Model;

/**
 * Class testSourceModel
 * @package Clubdeuce\WPLib\Components\Juicer\Tests
 *
 * @coversDefaultClass \Clubdeuce\WPLib\Components\Juicer\Source_Model
 */
class testSourceModel extends TestCase {

    /**
     * @var Source_Model;
     */
    private $_model;

    public function setUp() {

        $this->_model = new Source_Model();
        $this->_model->set_state(array('source_object' => $this->_get_sample_response()->sources[0]));
        parent::setUp();

    }

    /**
     * @covers ::has_source
     */
    public function testHasSourceFalse() {

        $model = new Source_Model();

        $this->assertFalse($model->has_source());

    }

    /**
     * @covers ::has_source
     */
    public function testHasSourceTrue() {

        $this->assertTrue($this->_model->has_source());

    }

    /**
     * @covers ::__call
     */
    public function testCall() {

        $this->assertEquals(181952, $this->_model->id());

    }

    /**
     * @covers ::__call
     */
    public function testCallFail() {

        $source = new Source_Model();

        $this->assertNull($source->id());

    }

    /**
     * @covers ::_source_object
     */
    public function testSourceObject() {

        $this->assertEquals(
            $this->_get_sample_response()->sources[0],
            $this->reflectionMethodInvoke($this->_model, '_source_object')
        );

    }

}
