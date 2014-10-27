<?php namespace Anomaly\Streams\Platform\Ui;

use Illuminate\Routing\Router;

/**
 * Class Utility
 * Simple utility methods to assist command handlers.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui
 */
class Utility
{

    /**
     * Available button type configuration defaults.
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
     * The router class.
     *
     * @var \Illuminate\Routing\Router
     */
    protected $router;

    /**
     * Create a new Utility instance.
     *
     * @param Router $router
     */
    function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Return an array parsed into a string of attributes.
     *
     * @param $attributes
     * @return string
     */
    public function attributes($attributes)
    {
        return implode(
            ' ',
            array_map(
                function ($v, $k) {

                    return $k . '=' . '"' . trans($v) . '"';

                },
                $attributes,
                array_keys($attributes)
            )
        );
    }

}
 