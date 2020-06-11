<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action;

use Illuminate\Support\Arr;
use Anomaly\Streams\Platform\Ui\Button\ButtonRegistry;

/**
 * Class ActionRegistry
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class ActionRegistry
{

    /**
     * Available actions.
     *
     * @var array
     */
    protected $actions = [
        'save'         => [
            'button' => 'save',
            'text'   => 'streams::button.save',
        ],
        'update'         => [
            'button' => 'update',
            'text'   => 'streams::button.update',
        ],
        'save_exit'      => [
            'button' => 'save',
            'text'   => 'streams::button.save_exit',
        ],
        'save_edit'      => [
            'button' => 'save',
            'text'   => 'streams::button.save_edit',
        ],
        'save_create'    => [
            'button' => 'save',
            'text'   => 'streams::button.save_create',
        ],
        'save_continue'  => [
            'button' => 'save',
            'text'   => 'streams::button.save_continue',
        ],
        'save_edit_next' => [
            'button' => 'save',
            'text'   => 'streams::button.save_edit_next',
        ],
    ];

    /**
     * Get a action.
     *
     * @param  $action
     * @return array|null
     */
    public function get($action)
    {
        if (!$action) {
            return null;
        }

        $registered = Arr::get($this->actions, $action);

        if ($button = app(ButtonRegistry::class)->get(Arr::get($registered, 'button'))) {
            $registered = array_replace_recursive($button, Arr::except($registered, ['button']));
        }

        return $registered;
    }

    /**
     * Register a action.
     *
     * @param        $action
     * @param  array $parameters
     * @return $this
     */
    public function register($action, array $parameters)
    {
        Arr::set($this->actions, $action, $parameters);

        return $this;
    }
}
