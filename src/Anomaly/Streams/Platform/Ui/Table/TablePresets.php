<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Ui\Presets;

/**
 * Class TablePresets
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table
 */
class TablePresets extends Presets
{

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
     * Set preset data for a button. Guess it's URL
     * afterward based on the slug.
     *
     * @param array $button
     */
    public function setButtonPresets(array $button)
    {
        $button = parent::setButtonPresets($button);

        if (!isset($button['url'])) {

            $button['url'] = $this->guessUrl($button['slug']);
        }

        return $button;
    }


    /**
     * Set preset data for an action.
     *
     * @param array $action
     * @return array
     */
    public function setActionPresets(array $action)
    {
        if (isset($this->actions[$action['slug']]) and $presets = $this->actions[$action['slug']]) {

            return array_merge($presets, $action);
        }

        return $action;
    }

    /**
     * Set preset data for a view.
     *
     * @param array $view
     * @return array
     */
    public function setViewPresets(array $view)
    {
        if (isset($this->views[$view['slug']]) and $presets = $this->views[$view['slug']]) {

            return array_merge($presets, $view);
        }

        return $view;
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
 