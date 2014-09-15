<?php namespace Streams\Core\Ui\Component;

use Illuminate\Support\Facades\Paginator;
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
    public function data()
    {
        $rows       = $this->makeRows();
        $views      = $this->makeViews();
        $headers    = $this->makeHeaders();
        $actions    = $this->makeActions();
        $pagination = $this->makePagination();
        $options    = $this->makeOptions();

        return compact('views', 'headers', 'rows', 'actions', 'options', 'pagination');
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
            $title = trans(evaluate_key($view, 'title', null, [$this->ui]));

            // @todo - This should look to the query string
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

            $rows[] = compact('columns', 'buttons', 'entry');
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

            $data = evaluate_key($column, 'data', null, [$this->ui, $entry]);

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
            $url = evaluate_key($button, 'url', '#', [$this->ui, $entry]);

            $title = trans(evaluate_key($button, 'title', null, [$this->ui, $entry]));

            $attributes = evaluate_key($button, 'attributes', [], [$this->ui, $entry]);

            $link = \HTML::link($url, $title, $attributes);

            $dropdown = evaluate_key($button, 'dropdown', [], [$this->ui, $entry]);

            foreach ($dropdown as &$item) {
                $url = evaluate_key($item, 'url', '#', [$this->ui, $entry]);

                $title = trans(evaluate_key($item, 'title', null, [$this->ui, $entry]));

                $item = compact('url', 'title');
            }

            $button = compact('link', 'attributes', 'dropdown');
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
                $header = trans(evaluate_key($header, 'header', null, [$this->ui]));
            } else {
                $header = humanize($header['data']);
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

        foreach ($actions as &$action) {
            $url = evaluate_key($action, 'url', '#', [$this->ui]);

            $title = trans(evaluate_key($action, 'title', null, [$this->ui]));

            $attributes = evaluate_key($action, 'attributes', [], [$this->ui]);

            $button = \HTML::link($url, $title, $attributes);

            $dropdown = evaluate_key($action, 'dropdown', [], [$this->ui]);

            foreach ($dropdown as &$item) {
                $url = evaluate_key($item, 'url', '#', [$this->ui]);

                $title = trans(evaluate_key($item, 'title', null, [$this->ui]));

                $item = compact('url', 'title');
            }

            $action = compact('button', 'attributes', 'dropdown');
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
            'sortable' => ($this->ui->isSortable()),
        ];
    }

    /**
     * Return the pagination array.
     *
     * @return array
     */
    protected function makePagination()
    {
        $paginator = $this->ui->getPaginator();

        $links = $paginator->links();

        $pagination = $paginator->toArray();

        $pagination['links'] = $links;

        return $pagination;
    }
}
