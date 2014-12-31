<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Action\Command;

use Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionResponder;

/**
 * Class SetFormResponseCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Action\Command
 */
class SetFormResponseCommandHandler
{

    /**
     * The action responder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\Component\Action\ActionResponder
     */
    protected $responder;

    /**
     * Create a new SetFormResponseCommandHandler instance.
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
     * @param SetFormResponseCommand $command
     */
    public function handle(SetFormResponseCommand $command)
    {
        $form    = $command->getForm();
        $actions = $form->getActions();

        if ($action = $actions->active()) {
            $this->responder->setFormResponse($form, $action->getFormResponseHandler());
        }
    }
}
