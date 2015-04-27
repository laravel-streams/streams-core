<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action;

/**
 * Class ActionRegistry
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
        'save_and_edit_next' => [
            'button' => 'save',
            'text'   => 'Save & Edit Next'
        ]
    ];

    /**
     * Get a action.
     *
     * @param  $action
     * @return array|null
     */
    public function get($action)
    {
        if (!$action) {
            return null;
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
