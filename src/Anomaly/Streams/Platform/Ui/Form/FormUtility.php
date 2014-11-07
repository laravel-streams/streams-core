<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Ui\Utility;

/**
 * Class FormUtility
 *
 * This is a simple utility object to
 * assist table command handlers.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormUtility extends Utility
{

    /**
     * Default redirect configurations.
     *
     * @var array
     */
    protected $redirects = [
        'save'          => [
            'title' => 'button.save',
            'class' => 'btn btn-sm btn-primary',
        ],
        'save_exit'     => [
            'title' => 'button.save_exit',
            'class' => 'btn btn-sm btn-success',
        ],
        'save_create'   => [
            'title' => 'button.save_create',
            'class' => 'btn btn-sm btn-success',
        ],
        'save_continue' => [
            'title' => 'button.save_continue',
            'class' => 'btn btn-sm btn-success',
        ],
    ];

    /**
     * Default action configurations.
     *
     * @var array
     */
    protected $actions = [
        'cancel' => [
            'title' => 'button.cancel',
            'class' => 'btn btn-sm btn-default',
        ],
        'view'   => [
            'title' => 'button.view',
            'class' => 'btn btn-sm btn-info',
        ],
        'delete' => [
            'title' => 'button.delete',
            'class' => 'btn btn-sm btn-danger',
        ],
    ];

    /**
     * Default section configurations.
     *
     * @var array
     */
    protected $sections = [
        'default' => [
            'handler' => 'Anomaly\Streams\Platform\Ui\Form\Section\DefaultFormSection',
        ],
        'tabbed'  => [
            'handler' => 'Anomaly\Streams\Platform\Ui\Form\Section\TabbedFormSection',
        ],
    ];

    /**
     * Get redirect defaults for a given type.
     *
     * @param $type
     * @return null
     */
    public function getRedirectDefaults($type)
    {
        if (isset($this->redirects[$type]) and $defaults = $this->redirects[$type]) {

            $defaults['url'] = $this->guessRedirectUrl($type);

            return $defaults;
        }

        return [];
    }

    /**
     * Get action defaults for a given type.
     *
     * @param $type
     * @return null
     */
    public function getActionDefaults($type)
    {
        if (isset($this->actions[$type]) and $defaults = $this->actions[$type]) {

            $defaults['url'] = $this->guessActionUrl($type);

            return $defaults;
        }

        return [];
    }

    /**
     * Get section defaults for a given type.
     *
     * @param $type
     * @return null
     */
    public function getSectionDefaults($type)
    {
        if (isset($this->sections[$type]) and $defaults = $this->sections[$type]) {

            return $defaults;
        }

        return [];
    }

    /**
     * Suggest best practices for URLs.
     *
     * URLs should be like: admin/module{/stream}/action/id
     * {/stream} is optional if the module slug == stream slug
     * like admin/users (would not be admin/users/users)
     *
     * @param $type
     * @return string
     */
    protected function guessRedirectUrl($type)
    {
        switch ($type) {

            // Change the last two segments.
            case 'save':
                $segments = explode('/', $this->request->path());
                $offset   = is_numeric(end($segments)) ? 2 : 1;

                return url(implode('/', array_slice($segments, 0, count($segments) - $offset)));
                break;

            default:
                return null;
                break;
        }
    }

    /**
     * Suggest best practices for URLs.
     *
     * URLs should be like: admin/module{/stream}/action/id
     * {/stream} is optional if the module slug == stream slug
     * like admin/users (would not be admin/users/users)
     *
     * @param $type
     * @return string
     */
    protected function guessActionUrl($type)
    {
        switch ($type) {

            // Change the last two segments.
            case 'cancel':
                $segments = explode('/', $this->request->path());

                return url(implode('/', array_slice($segments, 0, count($segments) - 2)));
                break;

            // Change the last two segments
            case 'view':
                $segments = explode('/', $this->request->path());

                return url(implode('/', array_slice($segments, 0, count($segments) - 2)) . '/show/{id}');
                break;

            // Change the last two segments
            case 'delete':
                $segments = explode('/', $this->request->path());

                return url(implode('/', array_slice($segments, 0, count($segments) - 2)) . '/delete/{id}');
                break;

            default:
                return null;
                break;
        }
    }

    /**
     * Standardize the layout of an area.
     *
     * @param array $section
     * @return mixed
     */
    public function standardizeLayout(array $container)
    {
        if (!isset($container['layout'])) {

            $fields  = evaluate_key($container, 'fields', []);
            $columns = evaluate_key($container, 'columns', [compact('fields')]);
            $rows    = evaluate_key($container, 'rows', [compact('columns')]);
            $layout  = evaluate_key($container, 'layout', compact('rows'));

            $container['layout'] = $layout;

            unset($container['fields'], $container['columns'], $container['rows']);
        }

        return $container;
    }

    /**
     * Register a redirect default.
     *
     * @param $type
     * @param $redirect
     */
    public function registerRedirect($type, $redirect)
    {
        $this->redirects[$type] = $redirect;
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
     * Register a section default.
     *
     * @param $type
     * @param $section
     */
    public function registerSection($type, $section)
    {
        $this->sections[$type] = $section;
    }

    /**
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * @return array
     */
    public function getRedirects()
    {
        return $this->redirects;
    }

    /**
     * @return array
     */
    public function getSections()
    {
        return $this->sections;
    }
}
 