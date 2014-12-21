<?php namespace Anomaly\Streams\Platform\Ui\Button;

use Anomaly\Streams\Platform\Ui\Button\Contract\ButtonRepositoryInterface;

/**
 * Class ButtonRepository
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Button
 */
class ButtonRepository implements ButtonRepositoryInterface
{

    /**
     * Available button.
     *
     * @var array
     */
    protected $buttons = [
        /**
         * Default type buttons.
         */
        'default' => [
            'type' => 'default',
        ],
        'cancel'  => [
            'text' => 'streams::button.cancel',
            'type' => 'default',
        ],
        /**
         * Primary type buttons.
         */
        'primary' => [
            'type' => 'primary',
        ],
        /**
         * Success type buttons.
         */
        'success' => [
            'type' => 'success',
        ],
        'save'    => [
            'type' => 'success',
            'text' => 'streams::button.save',
        ],
        /**
         * Info type buttons.
         */
        'info'    => [
            'type' => 'info',
        ],
        /**
         * Warning type buttons.
         */
        'warning' => [
            'type' => 'warning',
        ],
        'edit'    => [
            'text' => 'streams::button.edit',
            'type' => 'warning',
        ],
        /**
         * Danger type buttons.
         */
        'danger'  => [
            'type' => 'danger',
        ],
        'delete'  => [
            'text' => 'streams::button.delete',
            'type' => 'danger',
        ],
        /**
         * Link type buttons.
         */
        'link'    => [
            'type' => 'link',
        ],
    ];

    /**
     * Find a button.
     *
     * @param  $button
     * @return mixed
     */
    public function find($button)
    {
        return array_get($this->buttons, $button);
    }
}
