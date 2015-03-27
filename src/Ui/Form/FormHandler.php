<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Ui\Form\Event\FormIsSaving;
use Anomaly\Streams\Platform\Ui\Form\Event\FormWasSaved;
use Illuminate\Events\Dispatcher;

/**
 * Class FormHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Form
 */
class FormHandler
{

    /**
     * The event dispatcher.
     *
     * @var Dispatcher
     */
    protected $events;

    /**
     * Create a new FormHandler instance.
     *
     * @param Dispatcher $events
     */
    public function __construct(Dispatcher $events)
    {
        $this->events = $events;
    }

    /**
     * Handle the form.
     *
     * @param Form $form
     */
    public function handle(Form $form)
    {
        $form->fire('saving', compact('form'));
        $this->events->fire(new FormIsSaving($form));

        $form->save();

        $form->fire('saved', compact('form'));
        $this->events->fire(new FormWasSaved($form));
    }
}
