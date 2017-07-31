<?php namespace Anomaly\Streams\Platform\Ui\Form\Layout;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class LayoutFormBuilder
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class LayoutFormBuilder extends FormBuilder
{

    /**
     * The form options.
     *
     * @var array
     */
    protected $options = [
        'form_view' => 'streams::form/layout',
    ];

    /**
     * The form assets.
     *
     * @var array
     */
    protected $assets = [
        'scripts.js' => [
            'streams::js/form/layout.js',
        ],
    ];
}
