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

            return $defaults;

        }

        return null;
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

            $defaults['url'] = $this->guessRedirectUrl($type);

            return $defaults;

        }

        return null;
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

        return null;
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

            /**
             * Lop off the last two segments.
             * This should leave the index action.
             */
            case 'cancel':
                $segments = explode('/', $this->request->path());
                return url(implode('/', array_slice($segments, 0, count($segments) - 2)));
                break;

            /**
             * Lop off the last two segments
             * and append /show/{id}
             */
            case 'view':
                $segments = explode('/', $this->request->path());
                return url(implode('/', array_slice($segments, 0, count($segments) - 2)) . '/show/{id}');
                break;

            /**
             * Lop off the last two segments
             * and append /delete/{id}
             */
            case 'delete':
                $segments = explode('/', $this->request->path());
                return url(implode('/', array_slice($segments, 0, count($segments) - 2)) . '/delete/{id}');
                break;

            default:
                return null;
                break;

        }
    }

}
 