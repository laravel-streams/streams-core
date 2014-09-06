<?php namespace Streams\Core\Ui\Component;

use Streams\Core\Ui\TableUi;

class TableView
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
     * Make the view array.
     *
     * @param $view
     * @return array
     */
    public function make($view)
    {
        $title = trans(\ArrayHelper::value($view, 'title', null, [$this->ui]));

        $active = $title == 'All' ? true : false;

        return compact('title', 'active');
    }
}
