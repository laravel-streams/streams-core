<?php namespace Anomaly\Streams\Platform\Ui\Form;

class FormServiceTest extends \PHPUnit_Framework_TestCase
{
    protected static $form;

    public static function setUpBeforeClass()
    {
        $_GET['bar'] = 'foo';

        $form = self::$form = new Form;

        $form
            ->setSections(
                [
                    [
                        //
                    ]
                ]
            )
            ->setActions(
                [
                    [
                        'title' => 'Foo',
                    ]
                ]
            );
    }

    public function testSections()
    {
        $form = self::$form;

        $service = new FormBuilder($form);

        $expected = '162b7d05c9b8c332906d933ccaf269ca';
        $actual   = hashify($service->sections());

        $this->assertEquals($expected, $actual);
    }

    public function testActions()
    {
        $form = self::$form;

        $service = new FormBuilder($form);

        $expected = '618603c55bf8ff027c9bfdfeb85a4d4e';
        $actual   = hashify($service->actions());

        $this->assertEquals($expected, $actual);
    }
}
 