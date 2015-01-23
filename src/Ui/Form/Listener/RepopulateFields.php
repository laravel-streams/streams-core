<?php namespace Anomaly\Streams\Platform\Ui\Form\Listener;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Ui\Form\Event\ValidationFailed;
use Illuminate\Http\Request;

/**
 * Class RepopulateFields
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Listener
 */
class RepopulateFields
{

    /**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * Create a new RepopulateFields instance.
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
     * @param ValidationFailed $event
     */
    public function handle(ValidationFailed $event)
    {
        $form = $event->getForm();

        foreach ($form->getFields() as $field) {
            $this->repopulateField($field);
        }
    }

    /**
     * Repopulate the value for a field.
     *
     * @param FieldType $field
     */
    protected function repopulateField(FieldType $field)
    {
        if ($this->request->has($field->getFieldName())) {
            $field->setValue($this->request->get($field->getFieldName()));
        }
    }
}
