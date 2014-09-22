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
            'title'    => 'button.save',
            'redirect' => 'admin/addons/',
            'value'    => 'save',
            'name'     => 'formAction',
            'class'    => 'btn btn-sm btn-success',
        ],
        'save_exit'     => [
            'title'    => 'button.save_exit',
            'redirect' => 'admin/addons/modules',
            'value'    => 'save_exit',
            'name'     => 'formAction',
            'class'    => 'btn btn-sm btn-info',
        ],
        'save_continue' => [
            'title'    => 'button.save_continue',
            'redirect' => 'admin/addons/',
            'value'    => 'save_continue',
            'name'     => 'formAction',
            'class'    => 'btn btn-sm btn-info',
        ],
        'cancel'        => [
            'title' => 'button.cancel',
            'value' => 'cancel',
            'path'  => 'admin/addons/modules',
            'class' => 'btn btn-sm btn-default',
        ],
        'delete'        => [
            'title' => 'button.delete',
            'value' => 'delete',
            'path'  => 'admin/addons/',
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
        $button = $this->buildButton();

        return compact('button');
    }

    /**
     * Build the button.
     *
     * @return string
     */
    protected function buildButton()
    {
        $title = trans(evaluate($this->action->getOption('title'), [$this->ui]));

        if ($url = evaluate($this->action->getOption('path'), [$this->ui])) {
            $attributes = [
                'class' => $this->action->getOption('class'),
            ];

            return link_to(url($url), $title, $attributes);
        } else {
            $attributes = [
                'value' => $this->action->getOption('value'),
                'name'  => $this->action->getOption('name'),
                'class' => $this->action->getOption('class'),
            ];

            return \Form::submit($title, $attributes);
        }
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
