<?php namespace Streams\Platform\Ui;

class UiTest extends \PHPUnit_Framework_TestCase
{
    protected static $ui;

    public static function setUpBeforeClass()
    {
        self::$ui = new Ui;
    }

    public function testItCanRender()
    {
        /*$expected = 'sdlkfj';
        $actual   = md5(self::$ui->render());

        $this->assertEquals($expected, $actual);*/

        $this->assertTrue(false);
    }

    public function testItCanGetOutput()
    {
        $this->assertNull(self::$ui->getOutput());
    }
}
 