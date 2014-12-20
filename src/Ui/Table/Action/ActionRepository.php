<?php namespace Anomaly\Streams\Platform\Ui\Table\Action;

use Anomaly\Streams\Platform\Ui\Table\Action\Contract\ActionRepositoryInterface;

/**
 * Class ActionRepository
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Action
 */
class ActionRepository implements ActionRepositoryInterface
{

    /**
     * Available actions.
     *
     * @var array
     */
    protected $actions = [
        /**
         * Default type actions.
         */
        'default' => [
            'type' => 'default',
        ],
        'cancel'  => [
            'text' => 'streams::action.cancel',
            'type' => 'default',
        ],
        /**
         * Primary type actions.
         */
        'primary' => [
            'type' => 'primary',
        ],
        /**
         * Success type actions.
         */
        'success' => [
            'type' => 'success',
        ],
        /**
         * Info type actions.
         */
        'info'    => [
            'type' => 'info',
        ],
        /**
         * Warning type actions.
         */
        'warning' => [
            'type' => 'warning',
        ],
        'edit'    => [
            'text' => 'streams::action.edit',
            'type' => 'warning',
        ],
        /**
         * Danger type actions.
         */
        'danger'  => [
            'type' => 'danger',
        ],
        'delete'  => [
            'text' => 'streams::action.delete',
            'type' => 'danger',
        ],
        /**
         * Link type actions.
         */
        'link'    => [
            'type' => 'link',
        ],
    ];

    /**
     * Find a action.
     *
     * @param  $action
     * @return mixed
     */
    public function find($action)
    {
        return array_get($this->actions, $action);
    }
}
