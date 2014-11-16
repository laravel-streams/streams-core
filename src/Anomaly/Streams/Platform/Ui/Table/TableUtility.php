<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Anomaly\Streams\Platform\Ui\Utility;

/**
 * Class TableUtility
 *
 * This is a simple utility object to
 * assist table command handlers.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table
 */
class TableUtility extends Utility
{

    /**
     * Default button configurations.
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
        'default'    => [
            'class' => 'btn btn-sm btn-default',
        ],
        'view'       => [
            'title' => 'admin.button.view',
            'class' => 'btn btn-sm btn-info',
        ],
        'options'    => [
            'title' => 'admin.button.options',
            'class' => 'btn btn-sm btn-default',
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
        'gear-icon' => [
            'class' => 'btn btn-sm btn-link',
            'title' => '<i class="fa fa-gear"></i>',
        ],
        'trash-icon' => [
            'class' => 'btn btn-sm btn-link',
            'title' => '<i class="fa fa-trash"></i>',
        ],
    ];

    /**
     * Default action configurations.
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
        'default'    => [
            'class' => 'btn btn-sm btn-default',
        ],
        'view'       => [
            'title' => 'admin.button.view',
            'class' => 'btn btn-sm btn-info',
        ],
        'options'    => [
            'title' => 'admin.button.options',
            'class' => 'btn btn-sm btn-default',
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
     * Default view configurations.
     *
     * @var array
     */
    protected $views = [
        'all'               => [
            'title'   => 'misc.all',
            'slug'    => 'all',
            'handler' => 'Anomaly\Streams\Platform\Ui\Table\View\ViewAllTableView',
        ],
        'latest'            => [
            'title'   => 'misc.latest',
            'slug'    => 'latest',
            'handler' => 'Anomaly\Streams\Platform\Ui\Table\View\RecentlyCreatedTableView',
        ],
        'newest'            => [
            'title'   => 'misc.newest',
            'slug'    => 'newest',
            'handler' => 'Anomaly\Streams\Platform\Ui\Table\View\RecentlyCreatedTableView',
        ],
        'recently_created'  => [
            'title'   => 'misc.recently_created',
            'slug'    => 'recently_created',
            'handler' => 'Anomaly\Streams\Platform\Ui\Table\View\RecentlyCreatedTableView',
        ],
        'recently_modified' => [
            'title'   => 'misc.recently_modified',
            'slug'    => 'recently_modified',
            'handler' => 'Anomaly\Streams\Platform\Ui\Table\View\RecentlyModifiedTableView',
        ]
    ];

    /**
     * Return default button configuration for
     * a given button type.
     *
     * @param $type
     * @return null
     */
    public function getButtonDefaults($type)
    {
        if (isset($this->buttons[$type]) and $defaults = $this->buttons[$type]) {

            $defaults['url'] = $this->guessUrl($type);

            return $defaults;
        }

        return [];
    }


    /**
     * Return default button configuration for
     * a given action type.
     *
     * @param $type
     * @return null
     */
    public function getActionDefaults($type)
    {
        if (isset($this->actions[$type]) and $defaults = $this->actions[$type]) {

            return $defaults;
        }

        return [];
    }

    /**
     * Return default view configuration for
     * a given view type.
     *
     * @param $type
     * @return null
     */
    public function getViewDefaults($type)
    {
        if (isset($this->views[$type]) and $defaults = $this->views[$type]) {

            return $defaults;
        }

        return [];
    }

    /**
     * Try and guess a URL because we're awesome.
     * This of course can be overridden by setting one.
     *
     * @param $type
     */
    protected function guessUrl($type)
    {
        $path = $this->router->getCurrentRoute()->getPath();

        switch ($type) {

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
     * Register a button default.
     *
     * @param $type
     * @param $button
     */
    public function registerButton($type, $button)
    {
        $this->buttons[$type] = $button;
    }

    /**
     * Register an action default.
     *
     * @param $type
     * @param $action
     */
    public function registerAction($type, $action)
    {
        $this->actions[$type] = $action;
    }

    /**
     * Register a default view.
     *
     * @param $type
     * @param $view
     */
    public function registerView($type, $view)
    {
        $this->views[$type] = $view;
    }

    /**
     * Get the button defaults.
     *
     * @return array
     */
    public function getButtons()
    {
        return $this->buttons;
    }

    /**
     * Get the action default.
     *
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * Get the view defaults.
     *
     * @return array
     */
    public function getViews()
    {
        return $this->views;
    }
}
 