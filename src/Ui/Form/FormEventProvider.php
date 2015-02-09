<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;

/**
 * Class FormEventProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormEventProvider extends EventServiceProvider
{

    /**
     * Event listeners.
     *
     * @var array
     */
    protected $listen = [
        'Anomaly\Streams\Platform\Ui\Form\Event\ValidationFailed' => [
            'Anomaly\Streams\Platform\Ui\Form\Listener\RepopulateFields',
            'Anomaly\Streams\Platform\Ui\Form\Listener\AddErrorMessages'
        ],
        'Anomaly\Streams\Platform\Ui\Form\Event\FormWasPosted'    => [
            'Anomaly\Streams\Platform\Ui\Form\Listener\ValidateForm',
            'Anomaly\Streams\Platform\Ui\Form\Listener\HandleForm',
            'Anomaly\Streams\Platform\Ui\Form\Listener\SetFormResponse'
        ]
    ];

}
