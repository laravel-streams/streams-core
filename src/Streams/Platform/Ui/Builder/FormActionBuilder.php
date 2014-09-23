<?php namespace Streams\Platform\Ui\Builder;

use Streams\Platform\Ui\FormUi;

class FormActionBuilder extends FormBuilderAbstract
{
    /**
     * The action object.
     *
     * @var null
     */
    protected $action = null;

    /**
     * Pre-registered actions.
     *
     * @var array
     */
    protected $actions = [
        'save'          => [
            'title' => 'button.save',
            'value' => 'save',
            'name'  => 'formAction',
            'class' => 'btn btn-sm btn-success',
        ],
        'save_exit'     => [
            'title' => 'button.save_exit',
            'value' => 'save_exit',
            'name'  => 'formAction',
            'class' => 'btn btn-sm btn-info',
        ],
        'save_continue' => [
            'title' => 'button.save_continue',
            'value' => 'save_continue',
            'name'  => 'formAction',
            'class' => 'btn btn-sm btn-info',
        ],
        'cancel'        => [
            'title' => 'button.cancel',
            'class' => 'btn btn-sm btn-default',
        ],
        'delete'        => [
            'title' => 'button.delete',
            'class' => 'btn btn-sm btn-danger pull-right',
        ]
    ];

    /**
     * Return the data.
     *
     * @return array
     */
    public function data()
    {
        $url      = $this->buildUrl();
        $title    = $this->buildTitle();
        $class    = $this->buildClass();
        $value    = $this->buildValue();
        $dropdown = $this->buildDropdown();

        return compact('title', 'class', 'url', 'value', 'dropdown');
    }

    /**
     * Build the title.
     *
     * @return string
     */
    protected function buildTitle()
    {
        $default = $this->defaultValue('title');

        return trans(evaluate($this->action->getOption('title', $default), [$this->ui]));
    }

    /**
     * Build the class.
     *
     * @return mixed|null
     */
    protected function buildClass()
    {
        $default = $this->defaultValue('class');

        return evaluate($this->action->getOption('class', $default), [$this->ui]);
    }

    /**
     * Build the value.
     *
     * @return mixed|null
     */
    protected function buildValue()
    {
        $default = $this->defaultValue('value');

        return evaluate($this->action->getOption('value', $default), [$this->ui]);
    }

    /**
     * Build the url.
     *
     * @return mixed|null
     */
    protected function buildUrl()
    {
        $default = $this->defaultValue('path');

        return url(evaluate($this->action->getOption('path', $default), [$this->ui]));
    }

    /**
     * Build the dropdown.
     *
     * @return array
     */
    protected function buildDropdown()
    {
        $dropdown = [];

        foreach (evaluate($this->action->getOption('dropdown', []), [$this->ui]) as $options) {
            $title = trans($options['title']);
            $url   = url($options['path']);

            $dropdown[] = compact('title', 'url');
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
        if (isset($this->actions[$this->action->getOption('type')])) {
            if (isset($this->actions[$this->action->getOption('type')][$property])) {
                return $this->actions[$this->action->getOption('type')][$property];
            }
        }

        return $default;
    }

    /**
     * Set the action.
     *
     * @param $action
     * @return $this
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }
}
