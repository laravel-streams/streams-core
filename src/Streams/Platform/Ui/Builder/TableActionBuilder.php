<?php namespace Streams\Platform\Ui\Builder;

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
        $title  = $this->buildTitle();
        $class  = $this->buildClass();
        $action = $this->buildAction();

        return compact('title', 'class', 'action');
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
     * Return the action.
     *
     * @return mixed|null
     */
    protected function buildAction()
    {
        return url(evaluate_key($this->options, 'action', null, [$this->ui]));
    }
}
