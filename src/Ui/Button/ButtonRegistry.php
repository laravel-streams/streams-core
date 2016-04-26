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
        'default'       => [
            'type' => 'default'
        ],
        'cancel'        => [
            'text' => 'streams::button.cancel',
            'type' => 'default'
        ],
        /**
         * Success Buttons
         */
        'green'         => [
            'type' => 'success'
        ],
        'success'       => [
            'icon' => 'check',
            'type' => 'success'
        ],
        'save'          => [
            'text' => 'streams::button.save',
            'icon' => 'save',
            'type' => 'success'
        ],
        'update'        => [
            'text' => 'streams::button.save',
            'icon' => 'save',
            'type' => 'success'
        ],
        'create'        => [
            'text' => 'streams::button.create',
            'icon' => 'fa fa-asterisk',
            'type' => 'success'
        ],
        'new'           => [
            'text' => 'streams::button.new',
            'icon' => 'fa fa-plus',
            'type' => 'success'
        ],
        'new_field'     => [
            'text' => 'streams::button.new_field',
            'icon' => 'fa fa-plus',
            'type' => 'success'
        ],
        'add'           => [
            'text' => 'streams::button.add',
            'icon' => 'fa fa-plus',
            'type' => 'success'
        ],
        'add_field'     => [
            'text' => 'streams::button.add_field',
            'icon' => 'fa fa-plus',
            'type' => 'success'
        ],
        'assign_fields' => [
            'text' => 'streams::button.assign_fields',
            'icon' => 'fa fa-plus',
            'type' => 'success'
        ],
        'send'          => [
            'text' => 'streams::button.send',
            'icon' => 'envelope',
            'type' => 'success'
        ],
        'submit'        => [
            'text' => 'streams::button.submit',
            'type' => 'success'
        ],
        'install'       => [
            'text' => 'streams::button.install',
            'icon' => 'download',
            'type' => 'success'
        ],
        'entries'       => [
            'text' => 'streams::button.entries',
            'icon' => 'list-ol',
            'type' => 'success'
        ],
        'done'          => [
            'text' => 'streams::button.done',
            'type' => 'success',
            'icon' => 'check'
        ],
        'select'        => [
            'text' => 'streams::button.select',
            'type' => 'success',
            'icon' => 'check'
        ],
        'restore'       => [
            'text' => 'streams::button.restore',
            'type' => 'success',
            'icon' => 'repeat'
        ],
        'finish'        => [
            'text' => 'streams::button.finish',
            'type' => 'success',
            'icon' => 'check'
        ],
        'finished'      => [
            'text' => 'streams::button.finished',
            'type' => 'success',
            'icon' => 'check'
        ],
        /**
         * Info Buttons
         */
        'blue'          => [
            'type' => 'info'
        ],
        'info'          => [
            'type' => 'info'
        ],
        'information'   => [
            'text' => 'streams::button.info',
            'icon' => 'fa fa-info',
            'type' => 'info'
        ],
        'help'          => [
            'icon'        => 'circle-question-mark',
            'text'        => 'streams::button.help',
            'type'        => 'info',
            'data-toggle' => 'modal',
            'data-target' => '#modal'
        ],
        'view'          => [
            'text' => 'streams::button.view',
            'icon' => 'fa fa-eye',
            'type' => 'info'
        ],
        'export'        => [
            'text' => 'streams::button.export',
            'icon' => 'download',
            'type' => 'info'
        ],
        'fields'        => [
            'text' => 'streams::button.fields',
            'icon' => 'list-alt',
            'type' => 'info'
        ],
        'assignments'   => [
            'text' => 'streams::button.assignments',
            'icon' => 'list-alt',
            'type' => 'info'
        ],
        'settings'      => [
            'text' => 'streams::button.settings',
            'type' => 'info',
            'icon' => 'cog',
        ],
        'configure'     => [
            'text' => 'streams::button.configure',
            'icon' => 'wrench',
            'type' => 'info'
        ],
        /**
         * Warning Buttons
         */
        'orange'        => [
            'type' => 'warning'
        ],
        'warning'       => [
            'icon' => 'warning',
            'type' => 'warning'
        ],
        'edit'          => [
            'text' => 'streams::button.edit',
            'icon' => 'pencil',
            'type' => 'warning'
        ],
        /**
         * Danger Buttons
         */
        'red'           => [
            'type' => 'danger'
        ],
        'danger'        => [
            'icon' => 'fa fa-exclamation-circle',
            'type' => 'danger'
        ],
        'remove'        => [
            'text' => 'streams::button.remove',
            'type' => 'danger',
            'icon' => 'ban'
        ],
        'delete'        => [
            'icon'       => 'trash',
            'type'       => 'danger',
            'text'       => 'streams::button.delete',
            'attributes' => [
                'data-toggle'  => 'confirm',
                'data-message' => 'streams::message.confirm_delete'
            ]
        ],
        'prompt'        => [
            'icon'       => 'trash',
            'type'       => 'danger',
            'button'     => 'delete',
            'text'       => 'streams::button.delete',
            'attributes' => [
                'data-match'   => 'yes',
                'data-toggle'  => 'prompt',
                'data-message' => 'streams::message.prompt_delete'
            ]
        ],
        'uninstall'     => [
            'type'       => 'danger',
            'icon'       => 'times-circle',
            'text'       => 'streams::button.uninstall',
            'attributes' => [
                'data-toggle'  => 'confirm',
                'data-message' => 'streams::message.confirm_uninstall'
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
        if (!$button) {
            return null;
        }

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
