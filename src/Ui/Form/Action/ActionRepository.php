<?php namespace Anomaly\Streams\Platform\Ui\Form\Action;

use Anomaly\Streams\Platform\Ui\Form\Action\Contract\ActionRepositoryInterface;

/**
 * Class ActionRepository
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form\Action
 */
class ActionRepository implements ActionRepositoryInterface
{

    /**
     * Available actions.
     *
     * @var array
     */
    protected $actions = [
        'save' => [
            'type' => 'success',
            'text' => 'streams::button.save',
        ]
    ];

    /**
     * Find an action.
     *
     * @param  $action
     * @return mixed
     */
    public function find($action)
    {
        return array_get($this->actions, $action);
    }
}
