<?php

class PluginFormTest extends TestCase
{

    public function testCanBeResolved()
    {
        $form = $this->app->make(\Anomaly\Streams\Platform\Addon\Plugin\PluginForm::class);

        $this->assertInstanceOf(\Anomaly\Streams\Platform\Addon\Plugin\PluginForm::class, $form);
    }
}
