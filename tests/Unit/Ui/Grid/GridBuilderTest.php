<?php

class GridBuilderTest extends TestCase
{
    public function testGetRequestValue()
    {
        $this->call('GET', '/', ['test_test' => 'foo']);
        $gridBuilder = $this->app->make(\Anomaly\Streams\Platform\Ui\Grid\GridBuilder::class);

        $gridBuilder
            ->setOption('prefix', 'test_');

        $this->assertEquals($gridBuilder->getRequestValue('test'), 'foo');
    }
}
