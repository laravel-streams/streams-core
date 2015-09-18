<?php

namespace Anomaly\Streams\Platform\Ui\Form\Component\Action;

/**
 * Class ActionRegistry.
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Component\Action
 */
class ActionRegistry
{
    /**
     * Available actions.
     *
     * @var array
     */
    protected $actions = [
        'save_and_edit'      => [
            'button' => 'save',
            'text'   => 'streams::button.save_and_edit',
        ],
        'save_and_continue'  => [
            'button' => 'save',
            'text'   => 'streams::button.save_and_continue',
        ],
        'save_and_edit_next' => [
            'button' => 'save',
            'text'   => 'streams::button.save_and_edit_next',
        ],
    ];

    /**
     * Get a action.
     *
     * @param  $action
     * @return array|null
     */
    public function get($action)
    {
        if (! $action) {
            return;
        }

        return array_get($this->actions, $action);
    }

    /**
     * Register a action.
     *
     * @param       $action
     * @param array $parameters
     * @return $this
     */
    public function register($action, array $parameters)
    {
        array_set($this->actions, $action, $parameters);

        return $this;
    }
}
