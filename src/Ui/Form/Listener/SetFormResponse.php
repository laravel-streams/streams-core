<?php namespace Anomaly\Streams\Platform\Ui\Form\Listener;

use Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionResponder;
use Anomaly\Streams\Platform\Ui\Form\Event\FormWasPosted;

class SetFormResponse
{

    /**
     * The action responder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionResponder
     */
    protected $responder;

    /**
     * Create a new SetFormResponseHandler instance.
     *
     * @param ActionResponder $responder
     */
    public function __construct(ActionResponder $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Handle the event.
     *
     * @param FormWasPosted $event
     */
    public function handle(FormWasPosted $event)
    {
        $form    = $event->getForm();
        $actions = $form->getActions();

        if ($form->getErrors()) {
            return;
        }

        if ($action = $actions->active()) {
            $this->responder->setFormResponse($form, $action);
        }
    }
}
