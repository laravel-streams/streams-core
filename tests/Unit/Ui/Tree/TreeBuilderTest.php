<?php

class TreeBuilderTest extends TestCase
{
    public function testGetRequestValue()
    {
        $response = $this->call('GET', '/', ['test_test' => 'foo']);
        $treeBuilder = $this->app->make(\Anomaly\Streams\Platform\Ui\Tree\TreeBuilder::class);

        $treeBuilder
            ->setOption('prefix', 'test_');

        $this->assertEquals($treeBuilder->getRequestValue('test'), 'foo');
    }
}
