<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Ui\Utility;
use Anomaly\Streams\Platform\Ui\Form\Event\ConstructingFormUtilityEvent;

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
     * Create new FormUtility instance.
     */
    function __construct()
    {
        $this->dispatch(new ConstructingFormUtilityEvent($this));
    }

    /**
     * Get redirect default for a given type.
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
     * Get action default for a given type.
     *
     * @param $type
     * @return null
     */
    public function getActionDefaults($type)
    {
        if (isset($this->actions[$type]) and $defaults = $this->actions[$type]) {

            return $defaults;

        }

        return null;
    }

}
 