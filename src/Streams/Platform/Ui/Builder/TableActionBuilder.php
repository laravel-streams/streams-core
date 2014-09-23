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
        ],
    ];

    /**
     * Return the data.
     *
     * @return array
     */
    public function data()
    {
        $title    = $this->buildTitle();
        $class    = $this->buildClass();
        $action   = $this->buildAction();
        $dropdown = $this->buildDropdown();

        return compact('title', 'class', 'action', 'dropdown');
    }

    /**
     * Return the title.
     *
     * @return string
     */
    protected function buildTitle()
    {
        $default = $this->defaultValue('title');

        return trans(evaluate_key($this->options, 'title', $default, [$this->ui]));
    }

    /**
     * Return the class.
     *
     * @return string
     */
    protected function buildClass()
    {
        $default = $this->defaultValue('class');

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

    /**
     * Build the dropdown.
     *
     * @return array
     */
    protected function buildDropdown()
    {
        $dropdown = [];

        foreach (evaluate_key($this->options, 'dropdown', [], [$this->ui]) as $options) {
            $title  = trans($options['title']);
            $action = url($options['action']);

            $dropdown[] = compact('title', 'action');
        }

        return $dropdown;
    }

    /**
     * Return the pre-registered default value.
     *
     * @param      $property
     * @param null $default
     * @return null
     */
    protected function defaultValue($property, $default = null)
    {
        if (isset($this->options['type'])) {
            if (isset($this->actions[$this->options['type']])) {
                return $this->actions[$this->options['type']][$property];
            }
        }

        return $default;
    }
}
