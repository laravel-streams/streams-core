<?php namespace Anomaly\Streams\Platform\Ui\Form\Listener;

use Anomaly\Streams\Platform\Ui\Form\Event\FormWasPosted;
use Illuminate\Http\Request;

/**
 * Class LoadFormValues
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Listener
 */
class LoadFormValues
{

    /**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * Create a new LoadFormValues instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param FormWasPosted $event
     */
    public function handle(FormWasPosted $event)
    {
        $form = $event->getForm();

        // Get values from post.
        foreach ($this->request->except('_token', $form->getOption('prefix') . 'action') as $key => $value) {
            $form->setValue($key, $value);
        }
    }
}
