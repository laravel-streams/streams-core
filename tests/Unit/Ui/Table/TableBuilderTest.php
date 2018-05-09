<?php

class TableBuilderTest extends TestCase
{
    public function testGetRequestValue()
    {
        $this->call('GET', '/', ['test_test' => 'foo']);
        $tableBuilder = $this->app->make(\Anomaly\Streams\Platform\Ui\Table\TableBuilder::class);

        $tableBuilder
            ->setOption('prefix', 'test_');

        $this->assertEquals($tableBuilder->getRequestValue('test'), 'foo');
    }
}
