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
         * Default Buttons
         */
        'default'   => [
            'type' => 'default'
        ],
        'settings'  => [
            'icon' => 'cog',
            'type' => 'default',
            'text' => 'streams::button.settings'
        ],
        'configure' => [
            'icon' => 'cog',
            'type' => 'default',
            'text' => 'streams::button.configure'
        ],
        /**
         * Link Buttons
         */
        'cancel'    => [
            'text' => 'streams::button.cancel',
            'type' => 'link'
        ],
        /**
         * Success Buttons
         */
        'green'     => [
            'type' => 'success'
        ],
        'success'   => [
            'icon' => 'check',
            'type' => 'success'
        ],
        'save'      => [
            'text' => 'streams::button.save',
            'icon' => 'save',
            'type' => 'success'
        ],
        'create'    => [
            'text' => 'streams::button.create',
            'icon' => 'fa fa-asterisk',
            'type' => 'success'
        ],
        'new'       => [
            'icon' => 'fa fa-plus',
            'type' => 'success'
        ],
        'add'       => [
            'icon' => 'fa fa-plus',
            'type' => 'success'
        ],
        /**
         * Info Buttons
         */
        'blue'      => [
            'type' => 'info'
        ],
        'info'      => [
            'icon' => 'fa fa-info',
            'type' => 'info'
        ],
        'view'      => [
            'text' => 'streams::button.view',
            'icon' => 'fa fa-eye',
            'type' => 'info'
        ],
        /**
         * Warning Buttons
         */
        'orange'    => [
            'type' => 'warning'
        ],
        'warning'   => [
            'icon' => 'warning',
            'type' => 'warning'
        ],
        'edit'      => [
            'text' => 'streams::button.edit',
            'icon' => 'pencil',
            'type' => 'warning'
        ],
        'fields'    => [
            'text' => 'streams::button.fields',
            'icon' => 'list-alt',
            'type' => 'warning'
        ],
        /**
         * Danger Buttons
         */
        'red'       => [
            'type' => 'danger'
        ],
        'danger'    => [
            'icon' => 'fa fa-exclamation-circle',
            'type' => 'danger'
        ],
        'delete'    => [
            'handler'    => 'Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler\Delete@handle',
            'text'       => 'streams::button.delete',
            'icon'       => 'trash',
            'type'       => 'danger',
            'attributes' => [
                'data-toggle' => 'confirm'
            ]
        ],
        'confirm'   => [
            'type'       => 'danger',
            'attributes' => [
                'data-toggle' => 'confirm'
            ]
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
