<?php


class ArrayBuilderTest extends \Codeception\TestCase\Test
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

    public function testBuilder()
    {
        $builder = new \Mascame\Arrayer\Builder\ArrayBuilder(
            [
                'test' => 'coconut',
                'bar' => 'foo',
                'smiley!',
                '^^',
                'peanuts' => [
                    'under',
                    'attack',
                    'serious' => 'fact',
                ],
            ],
            [
                'oldSyntax' => false,
                'minify' => true,
                'indexes' => false,
                'startWithScript' => false,
                'initialStatement' => null,
            ]
        );

        $this->assertEquals($builder->getContent(), "['test'=>'coconut','bar'=>'foo','smiley!','^^','peanuts'=>['under','attack','serious'=>'fact',],];");

        $builder = new \Mascame\Arrayer\Builder\ArrayBuilder(
            [
                'test' => 'coconut',
                'bar' => 'foo',
                'smiley!',
                '^^',
                'peanuts' => [
                    'under',
                    'attack',
                    'serious' => 'fact',
                ],
            ],
            [
                'oldSyntax' => true,
                'minify' => true,
                'indexes' => false,
                'startWithScript' => false,
                'initialStatement' => null,
            ]
        );

        $this->assertEquals($builder->getContent(), "array ('test'=>'coconut','bar'=>'foo','smiley!','^^','peanuts'=>array('under','attack','serious'=>'fact',),);");

        $builder = new \Mascame\Arrayer\Builder\ArrayBuilder(
            [
                'test' => 'coconut',
                'bar' => 'foo',
                'smiley!',
                '^^',
                'peanuts' => [
                    'under',
                    'attack',
                    'serious' => 'fact',
                ],
            ],
            [
                'oldSyntax' => true,
                'minify' => true,
                'indexes' => true,
                'startWithScript' => false,
                'initialStatement' => null,
            ]
        );

        $this->assertEquals($builder->getContent(), "array ('test'=>'coconut','bar'=>'foo',0=>'smiley!',1=>'^^','peanuts'=>array(0=>'under',1=>'attack','serious'=>'fact',),);");
    }
}
