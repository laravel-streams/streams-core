<?php namespace Streams\Core\Ui\Component;

use Streams\Core\Ui\TableUi;

class TableColumn
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
     * Make a column array.
     *
     * @param $entry
     * @param $column
     * @return array
     */
    public function make($entry, $column)
    {
        if (is_string($column)) {
            $column = [
                'data' => $column
            ];
        }

        $data = $this->makeData($entry, $column);

        return compact('data');
    }

    /**
     * Return the data string.
     *
     * @param $entry
     * @param $column
     * @return string
     */
    protected function makeData($entry, $column)
    {
        $data = \ArrayHelper::value($column, 'data', null, [$this->ui, $entry]);

        if (isset($entry->{$data})) {
            $data = $entry->{$data};
        } elseif (strpos($data, '{{') !== false) {
            $data = \View::parse($data, $entry);
        } elseif (strpos($data, '.') !== false and $data = $entry) {
            foreach (explode('.', $data) as $attribute) {
                $data = $data->{$attribute};
            }
        }

        return $data;
    }
}
