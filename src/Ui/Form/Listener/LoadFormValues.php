<?php namespace Anomaly\Streams\Platform\Ui\Form\Listener;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Ui\Form\Event\FormIsPosting;
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
     * @param FormIsPosting $event
     */
    public function handle(FormIsPosting $event)
    {
        $form = $event->getForm();

        /* @var FieldType $field */
        foreach ($form->getFields() as $field) {
            $form->setValue($field->getInputName(), $field->getPostValue());
        }
    }
}
