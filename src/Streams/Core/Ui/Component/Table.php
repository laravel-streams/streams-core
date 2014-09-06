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

        $this->view   = $this->ui->newView($ui);
        $this->header = $this->ui->newHeader($ui);
        $this->row    = $this->ui->newRow($ui);
        $this->action = $this->ui->newAction($ui);
    }

    /**
     * Return the data needed to render the table.
     *
     * @return array
     */
    public function make()
    {
        $views   = $this->makeViews();
        $headers = $this->makeHeaders();
        $rows    = $this->makeRows();
        $actions = $this->makeActions();

        return compact('views', 'headers', 'rows', 'actions');
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
            $view = $this->view->make($view);
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
            $rows[] = $this->row->make($entry);
        }

        return $rows;
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
            $header = $this->header->make($header);
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
            $button = $this->action->make($button);
        }

        return $actions;
    }
}
