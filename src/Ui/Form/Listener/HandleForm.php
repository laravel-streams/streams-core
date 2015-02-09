<?php namespace Anomaly\Streams\Platform\Ui\Form\Listener;

use Anomaly\Streams\Platform\Ui\Form\Event\FormWasPosted;

/**
 * Class HandleForm
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Listener
 */
class HandleForm
{

    /**
     * Handle the event.
     *
     * @param FormWasPosted $event
     */
    public function handle(FormWasPosted $event)
    {
        $form = $event->getForm();

        // If validation failed then skip it.
        if ($form->getErrors()) {
            return;
        }

        $handler = $form->getOption('handler');

        /**
         * If the handler is a callable string or Closure then
         * we and can resolve it through the IoC container.
         */
        if (is_string($handler) || $handler instanceof \Closure) {
            app()->call($handler, compact('form'));
        }
    }
}
