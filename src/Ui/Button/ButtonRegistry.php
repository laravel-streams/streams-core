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
        'default' => [
            'type' => 'basic'
        ],
        'cancel'  => [
            'text' => 'streams::button.cancel',
            'type' => 'basic'
        ],
        /**
         * Green Buttons
         */
        'green'   => [
            'type' => 'green'
        ],
        'success' => [
            'icon' => 'icon checkmark',
            'type' => 'green'
        ],
        'save'    => [
            'text' => 'streams::button.save',
            'icon' => 'icon save',
            'type' => 'green'
        ],
        'create'  => [
            'text' => 'streams::button.create',
            'icon' => 'icon asterisk',
            'type' => 'green'
        ],
        'new'     => [
            'icon' => 'icon plus',
            'type' => 'green'
        ],
        /**
         * Blue Buttons
         */
        'blue'    => [
            'type' => 'blue'
        ],
        'info'    => [
            'icon' => 'icon info',
            'type' => 'blue'
        ],
        'view'    => [
            'text' => 'streams::button.view',
            'icon' => 'icon unhide',
            'type' => 'blue'
        ],
        /**
         * Orange type buttons.
         */
        'orange'  => [
            'type' => 'orange'
        ],
        'warning' => [
            'icon' => 'warning sign icon',
            'type' => 'orange'
        ],
        'edit'    => [
            'text' => 'streams::button.edit',
            'icon' => 'icon write',
            'type' => 'orange'
        ],
        /**
         * Red Buttons
         */
        'red'     => [
            'type' => 'red'
        ],
        'danger'  => [
            'icon' => 'warning circle icon',
            'type' => 'red'
        ],
        'remove'  => [
            'icon' => 'remove circle icon',
            'text'    => 'streams::button.remove',
            'type' => 'red'
        ],
        'delete'  => [
            'handler' => 'Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler\Delete@handle',
            'text'    => 'streams::button.delete',
            'icon'    => 'icon trash',
            'type'    => 'red'
        ],
        'reorder' => [
            'handler' => 'Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler\Reorder@handle',
            'text'    => 'streams::button.reorder',
            'type'    => 'red'
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
