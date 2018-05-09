<?php

class FormBuilderTest extends TestCase
{
    public function testGetRequestValue()
    {
        $this->call('GET', '/', ['test_test' => 'foo']);
        $formBuilder = $this->app->make(\Anomaly\Streams\Platform\Ui\Form\FormBuilder::class);

        $formBuilder
            ->setOption('prefix', 'test_');

        $this->assertEquals($formBuilder->getRequestValue('test'), 'foo');
    }

    public function testGetPostValue()
    {
        $this->call('POST', '/', ['test_test' => 'foo']);
        $formBuilder = $this->app->make(\Anomaly\Streams\Platform\Ui\Form\FormBuilder::class);

        $formBuilder
            ->setOption('prefix', 'test_');

        $this->assertEquals($formBuilder->getRequestValue('test'), 'foo');
    }
}
