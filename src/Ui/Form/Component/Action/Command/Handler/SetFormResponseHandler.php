<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action\Command\Handler;

use Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionResponder;
use Anomaly\Streams\Platform\Ui\Form\Component\Action\Command\SetFormResponse;

/**
 * Class SetFormResponseHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Action\Command
 */
class SetFormResponseHandler
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
     * Handle the command.
     *
     * @param SetFormResponse $command
     */
    public function handle(SetFormResponse $command)
    {
        $form    = $command->getForm();
        $actions = $form->getActions();

        if ($form->getErrors()) {
            return;
        }

        if ($action = $actions->active()) {
            $this->responder->setFormResponse($form, $action->getHandler());
        }
    }
}
