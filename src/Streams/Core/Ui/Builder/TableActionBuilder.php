<?php namespace Streams\Core\Ui\Builder;

class TableActionBuilder extends TableBuilderAbstract
{
    /**
     * Pre-registered actions.
     *
     * @var array
     */
    protected $actions = [
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
        return trans(evaluate_key($this->options, 'title', null, [$this->ui]));
    }

    /**
     * Return the class.
     *
     * @return string
     */
    protected function buildClass()
    {
        $default = 'btn btn-sm btn-default';

        return evaluate_key($this->options, 'class', $default, [$this->ui]);
    }

    /**
     * Return the URL.
     *
     * @return mixed|null
     */
    protected function buildUrl()
    {
        return evaluate_key($this->options, 'url', null, [$this->ui]);
    }
}
