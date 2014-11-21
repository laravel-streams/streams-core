<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Ui\Presets;

/**
 * Class FormPresets
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormPresets extends Presets
{

    /**
     * Redirect presets.
     *
     * @var array
     */
    protected $redirects = [
        'save'          => [
            'title' => 'admin.button.save',
            'class' => 'btn btn-sm btn-primary',
        ],
        'save_exit'     => [
            'title' => 'admin.button.save_exit',
            'class' => 'btn btn-sm btn-success',
        ],
        'save_create'   => [
            'title' => 'admin.button.save_create',
            'class' => 'btn btn-sm btn-success',
        ],
        'save_continue' => [
            'title' => 'admin.button.save_continue',
            'class' => 'btn btn-sm btn-success',
        ],
    ];

    /**
     * Action presets.
     *
     * @var array
     */
    protected $actions = [
        'cancel' => [
            'title' => 'admin.button.cancel',
            'class' => 'btn btn-sm btn-default',
        ],
        'view'   => [
            'title' => 'admin.button.view',
            'class' => 'btn btn-sm btn-info',
        ],
        'delete' => [
            'title' => 'admin.button.delete',
            'class' => 'btn btn-sm btn-danger',
        ],
    ];

    /**
     * Section presets.
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
     * Set redirect presets.
     *
     * @param $redirect
     * @return null
     */
    public function setRedirectPresets($redirect)
    {
        if (isset($this->redirects[$redirect['slug']]) and $presets = $this->redirects[$redirect['slug']]) {

            $presets['url'] = $this->guessRedirectUrl($redirect['slug']);

            return array_merge($presets, $redirect);
        }

        return $redirect;
    }

    /**
     * Set action presets.
     *
     * @param $action
     * @return null
     */
    public function setActionPresets($action)
    {
        if (isset($this->actions[$action['slug']]) and $presets = $this->actions[$action['slug']]) {

            $presets['url'] = $this->guessActionUrl($action['slug']);

            return array_merge($presets, $action);
        }

        return $action;
    }

    /**
     * Set section presets.
     *
     * @param $section
     * @return null
     */
    public function setSectionPresets($section)
    {
        if (isset($this->sections[$section['slug']]) and $presets = $this->sections[$section['slug']]) {

            return array_merge($presets, $section);
        }

        return $section;
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
                $segments = explode('/', app('request')->path());
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
                $segments = explode('/', app('request')->path());

                return url(implode('/', array_slice($segments, 0, count($segments) - 2)));
                break;

            // Change the last two segments
            case 'view':
                $segments = explode('/', app('request')->path());

                return url(implode('/', array_slice($segments, 0, count($segments) - 2)) . '/show/ID');
                break;

            // Change the last two segments
            case 'delete':
                $segments = explode('/', app('request')->path());

                return url(implode('/', array_slice($segments, 0, count($segments) - 2)) . '/delete/ID');
                break;

            default:
                return null;
                break;
        }
    }
}
 