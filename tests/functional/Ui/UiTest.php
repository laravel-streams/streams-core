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
        $expected = 'd41d8cd98f00b204e9800998ecf8427e';
        $actual   = md5(self::$ui->render());

        $this->assertEquals($expected, $actual);
    }

    public function testItCanGetOutput()
    {
        $this->assertNull(self::$ui->getOutput());
    }

    public function testItCanSetAndGetModel()
    {
        $this->assertEquals('foo', self::$ui->setModel('foo')->getModel());
    }

    public function testItCanSetAndGetTitle()
    {
        $this->assertEquals('foo', self::$ui->setTitle('foo')->getTitle());
    }

    public function testItCanSetWrapper()
    {
        self::$ui->setWrapper('foo');

        $this->assertTrue(true);
    }
}
 