<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

/**
 * Class RunFormHandlerCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class RunFormHandlerCommandHandler
{

    /**
     * Handle the command.
     *
     * @param RunFormHandlerCommand $command
     */
    public function handle(RunFormHandlerCommand $command)
    {
        $builder = $command->getBuilder();
        $handler = $builder->getHandler();
        $form    = $builder->getForm();

        if ($form->getResponse() === null) {
            if (is_string($handler) || $handler instanceof \Closure) {
                app()->call($handler, compact('builder'));
            }
        }
    }
}
