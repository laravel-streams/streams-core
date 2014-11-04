<?php namespace Anomaly\Streams\Platform\Ui\Table;

class TableServiceTest extends \PHPUnit_Framework_TestCase
{
    protected static $table;

    public static function setUpBeforeClass()
    {
        $_GET['bar'] = 'foo';

        $table = self::$table = new Table;

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
    }

    public function testViews()
    {
        $table = self::$table;

        $service = new TableService($table);

        $expected = '52674801ba3669f046e67789a358e4a8';
        $actual   = hashify($service->views());

        $this->assertEquals($expected, $actual);
    }

    public function testFilters()
    {
        $table = self::$table;

        $service = new TableService($table);

        $expected = 'bc1346509fa2035ae2fc6b3fdd67f7b3';
        $actual   = hashify($service->filters());

        $this->assertEquals($expected, $actual);
    }

    public function testHeaders()
    {
        $table = self::$table;

        $service = new TableService($table);

        $expected = 'd9e5448b0e4af791453f222d575eebb8';
        $actual   = hashify($service->headers());

        $this->assertEquals($expected, $actual);
    }

    public function testRows()
    {
        $table = self::$table;

        $service = new TableService($table);

        $expected = '904d153b44e14e159350730abaebe66d';
        $actual   = hashify($service->rows());

        $this->assertEquals($expected, $actual);
    }

    public function testActions()
    {
        $table = self::$table;

        $service = new TableService($table);

        $expected = '765cbd348eafdd43b208baf57c2532f7';
        $actual   = hashify($service->actions());

        $this->assertEquals($expected, $actual);
    }

    public function testPagination()
    {
        $table = self::$table;

        $service = new TableService($table);

        $expected = '4f7147196401e85b5765423d97e8e99b';
        $actual   = hashify($service->pagination());

        $this->assertEquals($expected, $actual);
    }

    public function testOptions()
    {
        $table = self::$table;

        $service = new TableService($table);

        $expected = '8f3c2b7106d0c478b314cadd2d404c4d';
        $actual   = hashify($service->options());

        $this->assertEquals($expected, $actual);
    }
}
 