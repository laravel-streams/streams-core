<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Support\Listener;
use Anomaly\Streams\Platform\Support\Messages;
use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Ui\Form\Command\HandleFormSubmissionCommand;
use Anomaly\Streams\Platform\Ui\Form\Event\AuthorizationFailedEvent;
use Anomaly\Streams\Platform\Ui\Form\Event\AuthorizationPassedEvent;
use Anomaly\Streams\Platform\Ui\Form\Event\FormWasSubmittedEvent;
use Anomaly\Streams\Platform\Ui\Form\Event\ValidationFailedEvent;
use Anomaly\Streams\Platform\Ui\Form\Event\ValidationPassedEvent;

/**
 * Class FormListener
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form
 */
class FormListener extends Listener
{

    use CommandableTrait;

    /**
     * Fire when the form request is a POST.
     *
     * @param FormWasSubmittedEvent $event
     */
    public function whenFormWasSubmitted(FormWasSubmittedEvent $event)
    {
        $ui = $event->getUi();

        $this->execute(new HandleFormSubmissionCommand($ui));
    }

    public function whenValidationPasses(ValidationPassedEvent $event, Messages $messages)
    {
        $ui = $event->getUi();

        $messages->add('success', 'YES!!!')->flash();
    }

    public function whenValidationFails(ValidationFailedEvent $event, Messages $messages)
    {
        $ui = $event->getUi();

        $messages->add('error', 'hell')->flash();
    }

    public function whenAuthorizationFails(AuthorizationFailedEvent $event, Messages $messages)
    {
        $ui = $event->getUi();

        $messages->add('error', $ui->getAuthorizationFailedMessage())->flash();
    }

    public function whenAuthorizationPasses(AuthorizationPassedEvent $event)
    {
        $ui = $event->getUi();

        $messages->add('error', $ui->getAuthorizationFailedMessage())->flash();
    }
}
 