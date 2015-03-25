<?php namespace Anomaly\Streams\Platform\Ui\Button;

/**
 * Class ButtonRegistry
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\Button
 */
class ButtonRegistry
{

    /**
     * Available buttons.
     *
     * @var array
     */
    protected $buttons = [
        /**
         * Basic Buttons
         */
        'default'     => [
            'type' => 'basic'
        ],
        'cancel'      => [
            'text' => 'streams::button.cancel',
            'type' => 'basic'
        ],
        /**
         * Green Buttons
         */
        'green'       => [
            'type' => 'green'
        ],
        'success'     => [
            'type' => 'green'
        ],
        'save'        => [
            'text' => 'streams::button.save',
            'type' => 'green'
        ],
        'create'      => [
            'text' => 'streams::button.create',
            'type' => 'green'
        ],
        'new'         => [
            'type' => 'green',
            'icon' => 'plus'
        ],
        /**
         * Blue Buttons
         */
        'blue'        => [
            'type' => 'blue'
        ],
        'info'        => [
            'type' => 'blue'
        ],
        'view'        => [
            'text' => 'streams::button.view',
            'type' => 'blue'
        ],
        /**
         * Orange type buttons.
         */
        'orange'      => [
            'type' => 'orange'
        ],
        'warning'     => [
            'type' => 'orange'
        ],
        'edit'        => [
            'text' => 'streams::button.edit',
            'type' => 'orange'
        ],
        /**
         * Red Buttons
         */
        'danger'      => [
            'type' => 'red',
        ],
        'delete'      => [
            'handler' => 'Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler\Delete@handle',
            'text'    => 'streams::button.delete',
            'type'    => 'red'
        ],
        'reorder'     => [
            'handler' => 'Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler\Reorder@handle',
            'text'    => 'streams::button.reorder',
            'type'    => 'red'
        ],
        'delete-icon' => [
            'icon' => 'trash',
            'type' => 'red'
        ]
    ];

    /**
     * Get a button.
     *
     * @param  $button
     * @return array|null
     */
    public function get($button)
    {
        return array_get($this->buttons, $button);
    }

    /**
     * Register a button.
     *
     * @param       $button
     * @param array $parameters
     * @return $this
     */
    public function register($button, array $parameters)
    {
        array_set($this->buttons, $button, $parameters);

        return $this;
    }
}
