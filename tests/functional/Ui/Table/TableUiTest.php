<?php namespace Anomaly\Streams\Platform\Ui\Table;

class TableUiTest extends \PHPUnit_Framework_TestCase
{
    protected static $table;

    public static function setUpBeforeClass()
    {
        self::$table = new Table;
    }

    public function testTrigger()
    {
        $table = self::$table;

        $table
            ->setEntries(
                [
                    [
                        'id'   => 1,
                        'slug' => 'Foo',
                    ],
                    [
                        'id'   => 2,
                        'slug' => 'Bar',
                    ]
                ]
            )
            ->setViews(
                [
                    [
                        'title'    => 'Foo',
                        'slug'     => 'foo',
                        'class'    => 'alert',
                        'listener' => function ($query) {
                                //
                            },
                    ],
                    [
                        'title'    => 'Bar',
                        'slug'     => 'bar',
                        'listener' => 'MyFooBarListener',
                    ],
                ]
            )
            ->setFilters(
                [
                    [
                        'type'          => 'select',
                        'slug'          => 'foo',
                        'placeholder'   => 'Pick foo...',
                        'default_value' => 'bar',
                        'options'       => [
                            'foo' => 'Foo',
                            'bar' => 'Bar',
                        ],
                    ],
                    [
                        'type'        => 'text',
                        'slug'        => 'bar',
                        'placeholder' => 'Pick bar...',
                    ],
                    [
                        'type' => 'field',
                        'slug' => 'baz',
                    ],
                    [
                        'type' => 'foo',
                    ]
                ]
            )
            ->setColumns(
                [
                    'id',
                    [
                        'title' => 'Foo',
                        'value' => function ($ui, $entry) {
                                return $entry['slug'];
                            }
                    ],
                ]
            )
            ->setActions(
                [
                    [
                        'test' => 'Foo',
                    ]
                ]
            );

        $expected = 'dd4b14bfc9bf7d716385f4ffeb949476';
        $actual   = hashify($table->trigger());

        $this->assertEquals($expected, $actual);
    }

    public function testItCanSetAndGetActions()
    {
        $this->assertEquals(['foo'], self::$table->setActions(['foo'])->getActions());
    }

    public function testItCanSetAndGetButtons()
    {
        $this->assertEquals(['foo'], self::$table->setButtons(['foo'])->getButtons());
    }

    public function testItCanSetAndGetColumns()
    {
        $this->assertEquals(['foo'], self::$table->setColumns(['foo'])->getColumns());
    }

    public function testItCanSetAndGetEntries()
    {
        $this->assertEquals(['foo'], self::$table->setEntries(['foo'])->getEntries());
    }

    public function testItCanSetAndGetFilters()
    {
        $this->assertEquals(['foo'], self::$table->setFilters(['foo'])->getFilters());
    }

    public function testItCanSetAndGetLimit()
    {
        $this->assertEquals('foo', self::$table->setLimit('foo')->getLimit());
    }

    public function testItCanSetAndGetNoResultsMessage()
    {
        $this->assertEquals('foo', self::$table->setNoResultsMessage('foo')->getNoResultsMessage());
    }

    public function testItCanSetAndGetOrderBy()
    {
        $this->assertEquals(
            ['column' => 'foo', 'direction' => 'desc'],
            self::$table->setOrderBy('foo', 'desc')->getOrderBy()
        );
    }

    public function testItCanSetAndGetPaginate()
    {
        $this->assertTrue(self::$table->setPaginate(true)->getPaginate());
    }

    public function testItCanSetAndGetRowClass()
    {
        $this->assertEquals('foo', self::$table->setRowClass('foo')->getRowClass());
    }

    public function testItCanSetAndGetSortable()
    {
        $this->assertTrue(self::$table->setSortable(true)->getSortable());
    }

    public function testItCanSetAndGetTableClass()
    {
        $this->assertEquals('foo', self::$table->setTableClass('foo')->getTableClass());
    }

    public function testItCanSetView()
    {
        self::$table->setView('foo');

        $this->assertTrue(true);
    }

    public function testItCanSetAndGetViews()
    {
        $this->assertEquals(['foo'], self::$table->setViews(['foo'])->getViews());
    }

    public function testItCanSetWrapper()
    {
        self::$table->setWrapper('foo');

        $this->assertTrue(true);
    }
}
 