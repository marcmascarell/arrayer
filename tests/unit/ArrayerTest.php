<?php


class ArrayerTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testEmptyArrayReturnsNull()
    {
        $arrayer = new \Mascame\Arrayer\Arrayer([]);
        $this->tester->assertEquals(null, $arrayer->get(''));
        $this->tester->assertEquals(null, $arrayer->get('something'));
    }

    public function testGetMethod()
    {
        $arrayer = new \Mascame\Arrayer\Arrayer([
            'test' => 'first value',
            'test2' => [
                'deep' => [
                    'deeper' => 'second value'
                ]
            ]
        ]);

        $this->tester->assertEquals('first value', $arrayer->get('test'));
        $this->tester->assertEquals('second value', $arrayer->get('test2.deep.deeper'));
        $this->tester->assertEquals('my default value', $arrayer->get('NON_EXISTANT', 'my default value'));
    }

    public function testSetMethod()
    {
        $arrayer = new \Mascame\Arrayer\Arrayer([
            'test' => 'first value'
        ]);

        $arrayer->set('test2', [
            'deep' => [
                'deeper' => 'second value'
            ]
        ]);

        $this->tester->assertEquals('first value', $arrayer->get('test'));
        $this->tester->assertEquals('second value', $arrayer->get('test2.deep.deeper'));
    }

    public function testDeleteMethod()
    {
        $arrayer = new \Mascame\Arrayer\Arrayer([
            'test' => 'first value'
        ]);

        $arrayer->delete('test');

        $this->tester->assertEquals(null, $arrayer->get('test'));
    }

    public function testHasMethod()
    {
        $arrayer = new \Mascame\Arrayer\Arrayer([]);
        $arrayer->set('fruit', 'coconut');
        $this->tester->assertTrue($arrayer->has('fruit'));
        $this->tester->assertFalse($arrayer->has('something-else'));
    }
}