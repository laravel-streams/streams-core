<?php namespace Anomaly\Streams\Platform\Ui\Form\Listener;

use Anomaly\Streams\Platform\Ui\Form\Event\FormWasPosted;

/**
 * Class ValidateForm
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Listener
 */
class ValidateForm
{

    /**
     * Handle the event.
     *
     * @param FormWasPosted $event
     */
    public function handle(FormWasPosted $event)
    {
        $form = $event->getForm();

        $validator = $form->getOption('validator');

        /**
         * If the validator is a string or Closure then it's a handler
         * and we and can resolve it through the IoC container.
         */
        if (is_string($validator) || $validator instanceof \Closure) {
            app()->call($validator, compact('form'));
        }
    }
}
