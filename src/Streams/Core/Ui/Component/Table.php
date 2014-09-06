<?php namespace Streams\Core\Ui\Component;

use Streams\Core\Ui\TableUi;

class Table
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
     * Return the data needed to render the table.
     *
     * @return array
     */
    public function make()
    {
        $rows    = $this->makeRows();
        $views   = $this->makeViews();
        $headers = $this->makeHeaders();
        $actions = $this->makeActions();
        $options = $this->makeOptions();

        return compact('views', 'headers', 'rows', 'actions', 'options');
    }

    /**
     * Return the views for a table.
     *
     * @return array
     */
    protected function makeViews()
    {
        $views = $this->ui->getViews();

        foreach ($views as &$view) {
            $title = trans(\ArrayHelper::value($view, 'title', null, [$this->ui]));

            $active = $title == 'All' ? true : false;

            $view = compact('title', 'active');
        }

        return $views;
    }

    /**
     * Return the rows for a table.
     *
     * @return mixed
     */
    protected function makeRows()
    {
        $rows = [];

        foreach ($this->ui->getEntries() as $entry) {
            $columns = $this->makeColumns($entry);
            $buttons = $this->makeButtons($entry);

            $rows[] = compact('columns', 'buttons');
        }

        return $rows;
    }

    /**
     * Return the columns array.
     *
     * @param $entry
     * @return string
     */
    protected function makeColumns($entry)
    {
        $columns = $this->ui->getColumns();

        foreach ($columns as &$column) {
            if (is_string($column)) {
                $column = [
                    'data' => $column
                ];
            }

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

            $column = compact('data');
        }

        return $columns;
    }

    /**
     * Return the buttons array.
     *
     * @param $entry
     * @return string
     */
    protected function makeButtons($entry)
    {
        $buttons = $this->ui->getButtons();

        foreach ($buttons as &$button) {
            $url = \ArrayHelper::value($button, 'url', '#', [$this->ui, $entry]);

            $title = trans(\ArrayHelper::value($button, 'title', null, [$this->ui, $entry]));

            $attributes = \ArrayHelper::value($button, 'attributes', [], [$this->ui, $entry]);

            $button = \HTML::link($url, $title, $attributes);

            $button = compact('button');
        }

        return $buttons;
    }

    /**
     * Return the headers for a table.
     *
     * @return array
     */
    protected function makeHeaders()
    {
        $headers = $this->ui->getColumns();

        foreach ($headers as &$header) {
            if (is_string($header)) {
                $header = [
                    'data' => $header
                ];
            }

            if (isset($column['header'])) {
                $header = trans(\ArrayHelper::value($header, 'header', null, [$this->ui]));
            } else {
                $header = \StringHelper::humanize($header['data']);
            }

            $header = compact('header');
        }

        return $headers;
    }

    /**
     * Return the actions array.
     *
     * @return string
     */
    protected function makeActions()
    {
        $actions = $this->ui->getActions();

        foreach ($actions as &$button) {
            $url = \ArrayHelper::value($button, 'url', '#', [$this->ui]);

            $title = trans(\ArrayHelper::value($button, 'title', null, [$this->ui]));

            $attributes = \ArrayHelper::value($button, 'attributes', [], [$this->ui]);

            $button = \HTML::link($url, $title, $attributes);

            $button = compact('button');
        }

        return $actions;
    }

    /**
     * Return the table options array.
     *
     * @return array
     */
    protected function makeOptions()
    {
        return [
            'sortable' => ($this->ui->getSortable()),
        ];
    }
}
