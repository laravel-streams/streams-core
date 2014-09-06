<?php namespace Streams\Core\Ui\Component;

use Streams\Core\Ui\TableUi;

class TableHeader
{
    /**
     * The table UI object.
     *
     * @var \Streams\Core\Ui\TableUi
     */
    protected $ui;

    /**
     * Create a new Table instance.
     *
     * @param TableUi $ui
     */
    public function __construct(TableUi $ui)
    {
        $this->ui = $ui;
    }

    /**
     * Make the header array.
     *
     * @param $column
     * @return array
     */
    public function make($column)
    {
        if (is_string($column)) {
            $column = [
                'data' => $column
            ];
        }

        if (isset($column['header'])) {
            $header = trans(\ArrayHelper::value($column, 'header', null, [$this->ui]));
        } else {
            $header = \StringHelper::humanize($column['data']);
        }

        return compact('header');
    }
}
