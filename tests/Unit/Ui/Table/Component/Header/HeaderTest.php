<?php

class HeaderTest extends TestCase
{
    public function testGetDirection()
    {
        $this->call('GET', '/', ['test_order_by' => 'test_column', 'test_sort' => 'asc']);
        $tableBuilder = $this->app->make(\Anomaly\Streams\Platform\Ui\Table\TableBuilder::class);
        $tableHeader = $this->app->make(\Anomaly\Streams\Platform\Ui\Table\Component\Header\Header::class);

        $tableBuilder
            ->setTableOption('prefix', 'test_');

        $tableHeader
            ->setSortColumn('test_column')
            ->setBuilder($tableBuilder);

        $this->assertEquals($tableHeader->getDirection(), 'asc');
    }

    public function testGetDirectionWithMismatchedSortColumn()
    {
        $this->call('GET', '/', ['test_order_by' => 'test_column', 'test_sort' => 'asc']);
        $tableBuilder = $this->app->make(\Anomaly\Streams\Platform\Ui\Table\TableBuilder::class);
        $tableHeader = $this->app->make(\Anomaly\Streams\Platform\Ui\Table\Component\Header\Header::class);

        $tableBuilder
            ->setTableOption('prefix', 'test_');

        $tableHeader
            ->setSortColumn('test_other_column')
            ->setBuilder($tableBuilder);

        $this->assertNull($tableHeader->getDirection());
    }

    public function testGetDirectionDefaultValue()
    {
        $this->call('GET', '/', ['test_order_by' => 'test_column']);
        $tableBuilder = $this->app->make(\Anomaly\Streams\Platform\Ui\Table\TableBuilder::class);
        $tableHeader = $this->app->make(\Anomaly\Streams\Platform\Ui\Table\Component\Header\Header::class);

        $tableBuilder
            ->setTableOption('prefix', 'test_');

        $tableHeader
            ->setSortColumn('test_column')
            ->setBuilder($tableBuilder);

        $this->assertEquals($tableHeader->getDirection('desc'), 'desc');
    }

    public function testGetQueryStringAsc()
    {
        $this->call('GET', '/', ['test_order_by' => 'test_column', 'test_sort' => 'asc']);
        $tableBuilder = $this->app->make(\Anomaly\Streams\Platform\Ui\Table\TableBuilder::class);
        $tableHeader = $this->app->make(\Anomaly\Streams\Platform\Ui\Table\Component\Header\Header::class);

        $tableBuilder
            ->setTableOption('prefix', 'test_');

        $tableHeader
            ->setSortColumn('test_column')
            ->setBuilder($tableBuilder);

        $this->assertEquals($tableHeader->getQueryString(), 'test_order_by=test_column&test_sort=asc');
    }

    public function testGetQueryStringDesc()
    {
        $this->call('GET', '/', ['test_order_by' => 'test_column', 'test_sort' => 'desc']);
        $tableBuilder = $this->app->make(\Anomaly\Streams\Platform\Ui\Table\TableBuilder::class);
        $tableHeader = $this->app->make(\Anomaly\Streams\Platform\Ui\Table\Component\Header\Header::class);

        $tableBuilder
            ->setTableOption('prefix', 'test_');

        $tableHeader
            ->setSortColumn('test_column')
            ->setBuilder($tableBuilder);

        $this->assertEquals($tableHeader->getQueryString(), 'test_order_by=test_column&test_sort=desc');
    }
}
