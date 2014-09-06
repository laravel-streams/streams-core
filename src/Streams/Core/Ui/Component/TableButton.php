<?php namespace Streams\Core\Ui\Component;

use Streams\Core\Ui\TableUi;

class TableButton
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
     * Make a button array.
     *
     * @param $entry
     * @param $button
     * @return array
     */
    public function make($entry, $button)
    {
        $url = $this->makeUrl($entry, $button);

        $title = trans(\ArrayHelper::value($button, 'title', null, [$this->ui, $entry]));

        $attributes = \ArrayHelper::value($button, 'attributes', [], [$this->ui, $entry]);

        $button = \HTML::link($url, $title, $attributes);

        return compact('button');
    }

    /**
     * Return the URL string.
     *
     * @param $entry
     * @param $button
     * @return \Illuminate\View\View|string
     */
    protected function makeUrl($entry, $button)
    {
        $url = \ArrayHelper::value($button, 'url', '#', [$this->ui, $entry]);

        if (strpos($url, '{{') !== false) {
            $url = \View::parse($url, $entry);
        }

        return $url;
    }
}
