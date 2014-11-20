<?php namespace Anomaly\Streams\Platform\Ui;

/**
 * Class Presets
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui
 */
class Presets
{

    /**
     * Button presets.
     *
     * @var array
     */
    protected $buttons = [
        'success'    => [
            'class' => 'btn btn-sm btn-success',
        ],
        'info'       => [
            'class' => 'btn btn-sm btn-info',
        ],
        'warning'    => [
            'class' => 'btn btn-sm btn-warning',
        ],
        'danger'     => [
            'class' => 'btn btn-sm btn-danger',
        ],
        'preset'     => [
            'class' => 'btn btn-sm btn-preset',
        ],
        'view'       => [
            'title' => 'admin.button.view',
            'class' => 'btn btn-sm btn-info',
        ],
        'options'    => [
            'title' => 'admin.button.options',
            'class' => 'btn btn-sm btn-preset',
        ],
        'edit'       => [
            'title' => 'admin.button.edit',
            'class' => 'btn btn-sm btn-warning',
        ],
        'delete'     => [
            'title' => 'admin.button.delete',
            'class' => 'btn btn-sm btn-danger',
        ],
        'confirm'    => [
            'class'        => 'btn btn-sm btn-danger',
            'data-confirm' => 'confirm.delete',
        ],
        'gear-icon'  => [
            'class' => 'btn btn-sm btn-link',
            'title' => '<i class="fa fa-gear"></i>',
        ],
        'trash-icon' => [
            'class' => 'btn btn-sm btn-link',
            'title' => '<i class="fa fa-trash"></i>',
        ],
    ];

    /**
     * Set preset data for a button.
     *
     * @param array $slug
     * @return array
     */
    public function setButtonPresets(array $button)
    {
        if (isset($this->buttons[$button['slug']]) and $presets = $this->buttons[$button['slug']]) {

            return array_merge($presets, $button);
        }

        return $button;
    }
}
 