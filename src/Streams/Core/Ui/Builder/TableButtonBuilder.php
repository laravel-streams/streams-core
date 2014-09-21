<?php namespace Streams\Platform\Ui\Builder;

class TableButtonBuilder extends TableBuilderAbstract
{
    /**
     * The entry object.
     *
     * @var null
     */
    protected $entry = null;

    /**
     * Pre-registered buttons.
     *
     * @var array
     */
    protected $buttons = [
        'delete' => [
            'title' => 'button.delete',
            'class' => 'btn btn-sm btn-danger',
        ]
    ];

    /**
     * Return the data.
     *
     * @return array
     */
    public function data()
    {
        $title = $this->buildTitle();
        $class = $this->buildClass();
        $url   = $this->buildUrl();

        return compact('title', 'class', 'url');
    }

    /**
     * Return the title.
     *
     * @return string
     */
    protected function buildTitle()
    {
        return trans(evaluate_key($this->options, 'title', null, [$this->ui, $this->entry]));
    }

    /**
     * Return the class.
     *
     * @return string
     */
    protected function buildClass()
    {
        $default = 'btn btn-sm btn-default';

        return evaluate_key($this->options, 'class', $default, [$this->ui, $this->entry]);
    }

    /**
     * Return the URL.
     *
     * @return mixed|null
     */
    protected function buildUrl()
    {
        return url(evaluate_key($this->options, 'path', null, [$this->ui, $this->entry]));
    }

    /**
     * Set the entry.
     *
     * @param null $entry
     */
    public function setEntry($entry)
    {
        $this->entry = $entry;

        return $this;
    }
}
