<?php namespace Anomaly\Streams\Platform\Ui\Table;

use Illuminate\Routing\Router;
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
        'success' => [
            'class' => 'btn btn-sm btn-success',
        ],
        'info'    => [
            'class' => 'btn btn-sm btn-info',
        ],
        'warning' => [
            'class' => 'btn btn-sm btn-warning',
        ],
        'danger'  => [
            'class' => 'btn btn-sm btn-danger',
        ],
        'view'    => [
            'title' => 'button.view',
            'class' => 'btn btn-sm btn-default',
        ],
        'options' => [
            'title' => 'button.options',
            'class' => 'btn btn-sm btn-default',
        ],
        'edit'    => [
            'title' => 'button.edit',
            'class' => 'btn btn-sm btn-warning',
        ],
        'delete'  => [
            'title'        => 'button.delete',
            'class'        => 'btn btn-sm btn-danger',
            'data-confirm' => 'confirm.delete',
        ],
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

            $this->guessUrl($type, $defaults);

            return $defaults;

        }

        return null;
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

            //$this->guessAction($type, $defaults);

            return $defaults;

        }

        return null;
    }

    /**
     * Try and guess a URL because we're awesome.
     * This of course can be overridden by setting one.
     *
     * @param $type
     * @param $defaults
     */
    protected function guessUrl($type, &$defaults)
    {
        $path = $this->router->getCurrentRoute()->getPath();

        switch ($type) {

            /**
             * Suggest best practices for view URLs
             */
            case 'view':
                $defaults['url'] = $path .= '/show/{id}';
                break;

            /**
             * Suggest best practices for edit URLs
             */
            case 'edit':
                $defaults['url'] = $path .= '/edit/{id}';
                break;

            /**
             * Suggest best practices for delete URLs
             */
            case 'delete':
                $defaults['url'] = $path .= '/delete/{id}';
                break;
        }
    }

}
 