<?php namespace Anomaly\Streams\Platform\Ui\Form\Listener;

use Anomaly\Streams\Platform\Ui\Form\Event\FormIsPosting;

/**
 * Class RemoveDisabledFields
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Listener
 */
class RemoveDisabledFields
{

    /**
     * Handle the event.
     *
     * @param FormIsPosting $event
     */
    public function handle(FormIsPosting $event)
    {
        $form = $event->getForm();

        $fields = $form->getFields();

        $form->setFields($fields->enabled());
    }
}
