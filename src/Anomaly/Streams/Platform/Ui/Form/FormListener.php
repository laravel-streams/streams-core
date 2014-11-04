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
        $form = $event->getForm();

        $this->execute(new HandleFormSubmissionCommand($form));
    }

    public function whenValidationPassed(ValidationPassedEvent $event, Messages $messages)
    {
        $form = $event->getForm();

        $messages->add('success', 'YES!!!')->flash();
    }

    public function whenValidationFailed(ValidationFailedEvent $event, Messages $messages)
    {
        $form = $event->getForm();

        $messages->add('error', 'hell')->flash();
    }

    public function whenAuthorizationFailed(AuthorizationFailedEvent $event, Messages $messages)
    {
        $form = $event->getForm();

        $messages->add('error', $form->getAuthorizationFailedMessage())->flash();
    }

    public function whenAuthorizationPassed(AuthorizationPassedEvent $event, Messages $messages)
    {
        $form = $event->getForm();

        $messages->add('error', $form->getAuthorizationFailedMessage())->flash();
    }
}
 