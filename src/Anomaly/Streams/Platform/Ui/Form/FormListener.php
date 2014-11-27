<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Support\Listener;
use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Ui\Form\Command\HandleFormSubmissionCommand;
use Anomaly\Streams\Platform\Ui\Form\Event\AuthorizationFailedEvent;
use Anomaly\Streams\Platform\Ui\Form\Event\AuthorizationPassedEvent;
use Anomaly\Streams\Platform\Ui\Form\Event\SubmittedEvent;
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
     * Fired when the form's request is a POST.
     *
     * @param SubmittedEvent $event
     */
    public function whenSubmitted(SubmittedEvent $event)
    {
        $form = $event->getForm();

        $this->execute(new HandleFormSubmissionCommand($form));
    }

    /**
     * Fired after form validation passes.
     *
     * @param ValidationPassedEvent $event
     */
    public function whenValidationPassed(ValidationPassedEvent $event)
    {
        app('streams.messages')->add('success', 'YOU ROCK!')->flash();
    }

    /**
     * Fired after form validation fails.
     *
     * @param ValidationFailedEvent $event
     */
    public function whenValidationFailed(ValidationFailedEvent $event)
    {
        app('streams.messages')->add('error', $event->getForm()->getErrors()->all());
    }

    /**
     * Fired after form authorization passes.
     *
     * @param AuthorizationPassedEvent $event
     */
    public function whenAuthorizationPassed(AuthorizationPassedEvent $event)
    {
    }

    /**
     * Fired after form authorization fails.
     *
     * @param AuthorizationFailedEvent $event
     */
    public function whenAuthorizationFailed(AuthorizationFailedEvent $event)
    {
        app('streams.messages')->add('error', $event->getForm()->getAuthorizationFailedMessage());
    }
}
 