<?php namespace Anomaly\Streams\Platform\Ui\Form;

class FormUiTest extends \PHPUnit_Framework_TestCase
{
    protected static $form;

    public static function setUpBeforeClass()
    {
        self::$form = new FormUi;
    }

    public function testItCanSetAndGetSkips()
    {
        $this->assertEquals(['foo'], self::$form->setSkips(['foo'])->getSkips());
    }

    public function testItCanSetAndGetSections()
    {
        $this->assertEquals(['foo'], self::$form->setSections(['foo'])->getSections());
    }

    public function testItCanSetAndGetActions()
    {
        $this->assertEquals(['foo'], self::$form->setActions(['foo'])->getActions());
    }

    public function testItCanSetView()
    {
        self::$form->setView('foo');

        $this->assertTrue(true);
    }
}
 