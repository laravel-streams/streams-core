<?php namespace Anomaly\Streams\Platform\Ui\Table;

/**
 * Class TablePresets
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table
 */
class TablePresets
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
     * Preset action configurations.
     *
     * @var array
     */
    protected $actions = [
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
        'trash-icon' => [
            'class' => 'btn btn-sm btn-link',
            'title' => '<i class="fa fa-trash"></i>',
        ],
    ];

    /**
     * Preset view configurations.
     *
     * @var array
     */
    protected $views = [
        'all' => [
            'title'   => 'misc.all',
            'handler' => 'Anomaly\Streams\Platform\Ui\Table\View\All',
        ]
    ];

    /**
     * Return button presets by slug.
     *
     * @param $slug
     * @return null
     */
    public function getButtonPresets($slug)
    {
        if (isset($this->buttons[$slug]) and $presets = $this->buttons[$slug]) {

            $presets['url'] = $this->guessUrl($slug);

            return $presets;
        }

        return [];
    }


    /**
     * Return preset button configuration for
     * a given action type.
     *
     * @param $slug
     * @return null
     */
    public function getActionPresets($slug)
    {
        if (isset($this->actions[$slug]) and $presets = $this->actions[$slug]) {

            return $presets;
        }

        return [];
    }

    /**
     * Return preset view configuration for
     * a given view type.
     *
     * @param $slug
     * @return null
     */
    public function getViewPresets($slug)
    {
        if (isset($this->views[$slug]) and $presets = $this->views[$slug]) {

            return $presets;
        }

        return [];
    }

    /**
     * Try and guess a URL because we're awesome.
     * This of course can be overridden by setting one.
     *
     * @param $slug
     */
    protected function guessUrl($slug)
    {
        $path = app('router')->getCurrentRoute()->getPath();

        switch ($slug) {

            // Suggest best practices for view URLs
            case 'view':
                return $path .= '/show/{id}';
                break;

            // Suggest best practices for edit URLs
            case 'edit':
                return $path .= '/edit/{id}';
                break;

            // Suggest best practices for delete URLs
            case 'delete':
                return $path .= '/delete/{id}';
                break;

            default:
                return null;
                break;
        }
    }

    /**
     * Add a button preset.
     *
     * @param $slug
     * @param $button
     */
    public function addButton($slug, $button)
    {
        $this->buttons[$slug] = $button;
    }

    /**
     * Add an action preset.
     *
     * @param $slug
     * @param $action
     */
    public function addAction($slug, $action)
    {
        $this->actions[$slug] = $action;
    }

    /**
     * Add a view preset.
     *
     * @param $slug
     * @param $view
     */
    public function addView($slug, $view)
    {
        $this->views[$slug] = $view;
    }
}
 