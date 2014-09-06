<?php namespace Streams\Core\Ui\Component;

use Streams\Core\Ui\TableUi;

class TableAction
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
     * Make an action array.
     *
     * @param $entry
     * @param $button
     * @return array
     */
    public function make($button)
    {
        $url = \ArrayHelper::value($button, 'url', '#', [$this->ui]);

        $title = trans(\ArrayHelper::value($button, 'title', null, [$this->ui]));

        $attributes = \ArrayHelper::value($button, 'attributes', [], [$this->ui]);

        $button = \HTML::link($url, $title, $attributes);

        return compact('button');
    }
}
