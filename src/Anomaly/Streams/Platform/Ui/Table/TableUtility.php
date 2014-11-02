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
            'title' => 'button.view',
            'class' => 'btn btn-sm btn-info',
        ],
        'options'    => [
            'title' => 'button.options',
            'class' => 'btn btn-sm btn-default',
        ],
        'edit'       => [
            'title' => 'button.edit',
            'class' => 'btn btn-sm btn-warning',
        ],
        'delete'     => [
            'title' => 'button.delete',
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
        if (isset($this->buttons[$type]) and $defaults = $this->buttons[$type]) {

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
}
 