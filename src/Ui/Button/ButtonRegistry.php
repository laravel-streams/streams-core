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
        'reorder' => [
            'handler' => 'Anomaly\Streams\Platform\Ui\Table\Component\Action\Handler\ReorderActionHandler@handle',
            'text'    => 'streams::button.reorder',
            'type'    => 'danger',
        ],
        /**
         * Link type buttons.
         */
        'link'    => [
            'type' => 'link',
        ],
    ];

    /**
     * Get a button.
     *
     * @param  $button
     * @return mixed
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
