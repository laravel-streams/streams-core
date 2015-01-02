<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action\Listener;

use Anomaly\Streams\Platform\Ui\Form\Event\FormPostEvent;
use Laracasts\Commander\CommanderTrait;

/**
 * Class FormPostListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Action\Listener
 */
class FormPostListener
{

    use CommanderTrait;

    /**
     * Handle the event.
     *
     * @param FormPostEvent $event
     */
    public function handle(FormPostEvent $event)
    {
        // Run the active action's FormPostHandler.
        $this->execute(
            '\Anomaly\Streams\Platform\Ui\Form\Component\Action\Command\RunFormPostHookCommand',
            compact('event')
        );
    }
}
