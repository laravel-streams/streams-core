<?php namespace Anomaly\Streams\Platform\Ui\Form\Listener;

use Anomaly\Streams\Platform\Message\MessageBag;
use Anomaly\Streams\Platform\Ui\Form\Event\ValidationFailed;

/**
 * Class AddErrorMessages
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Listener
 */
class AddErrorMessages
{

    /**
     * The message bag.
     *
     * @var MessageBag
     */
    protected $messages;

    /**
     * Create a new AddErrorMessages instance.
     *
     * @param MessageBag $messages
     */
    public function __construct(MessageBag $messages)
    {
        $this->messages = $messages;
    }

    /**
     * Handle the event.
     *
     * @param ValidationFailed $event
     */
    public function handle(ValidationFailed $event)
    {
        $form = $event->getForm();

        $errors = $form->getErrors();

        if ($errors instanceof \Illuminate\Support\MessageBag) {
            $this->messages->error($errors->all());
        }
    }
}
