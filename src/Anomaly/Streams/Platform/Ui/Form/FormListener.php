<?php namespace Anomaly\Streams\Platform\Ui\Form;

use Anomaly\Streams\Platform\Support\Listener;
use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Ui\Form\Command\HandleFormDataCommand;
use Anomaly\Streams\Platform\Ui\Form\Command\HandleFormPostCommand;
use Anomaly\Streams\Platform\Ui\Form\Command\HandleFormResponseCommand;
use Anomaly\Streams\Platform\Ui\Form\Event\AuthorizationFailedEvent;
use Anomaly\Streams\Platform\Ui\Form\Event\AuthorizationPassedEvent;
use Anomaly\Streams\Platform\Ui\Form\Event\PostedEvent;
use Anomaly\Streams\Platform\Ui\Form\Event\PostingEvent;
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
     * Fired when the form's is posting.
     *
     * @param PostingEvent $event
     */
    public function whenPosting(PostingEvent $event)
    {
        $this->execute(new HandleFormPostCommand($event->getForm()));
    }

    /**
     * Fired after form has been posted, authorized and validated.
     *
     * @param PostedEvent $event
     */
    public function whenPosted(PostedEvent $event)
    {
        $this->execute(new HandleFormDataCommand($event->getForm()));
        $this->execute(new HandleFormResponseCommand($event->getForm()));
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
        app('streams.messages')->add('error', $event->getForm()->getErrors()->all())->flash();
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
 