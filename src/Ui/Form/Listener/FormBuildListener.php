<?php namespace Anomaly\Streams\Platform\Ui\Form\Listener;

use Anomaly\Streams\Platform\Ui\Form\Event\FormBuildEvent;
use Laracasts\Commander\CommanderTrait;

/**
 * Class FormBuildListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Listener
 */
class FormBuildListener
{

    use CommanderTrait;

    /**
     * Handle the event.
     *
     * @param FormBuildEvent $event
     */
    public function handle(FormBuildEvent $event)
    {
        $builder = $event->getBuilder();

        // Set the table's model object from the builder's model.
        $this->execute('Anomaly\Streams\Platform\Ui\Form\Command\SetFormModelCommand', compact('builder'));

        // Set the table's stream object based on the builder's model.
        $this->execute('Anomaly\Streams\Platform\Ui\Form\Command\SetFormStreamCommand', compact('builder'));
    }
}
