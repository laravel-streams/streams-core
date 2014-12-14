<?php namespace Anomaly\Streams\Platform\Ui\Form\Action\Command;

/**
 * Class HandleFormActionCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Action\Command
 */
class HandleFormActionCommandHandler
{
    /**
     * Handle the command.
     *
     * @param HandleFormActionCommand $command
     */
    public function handle(HandleFormActionCommand $command)
    {
        $builder = $command->getBuilder();
        $form    = $builder->getForm();
        $actions = $form->getActions();

        if ($form->getResponse() === null && $action = $actions->active()) {
            $handler = $action->getHandler();

            if (is_string($handler) || $handler instanceof \Closure) {
                app()->call($handler, compact('table', 'ids'));
            }

            if ($handler === null) {
                $action->handle($form);
            }

            if ($form->getResponse() === null) {
                $form->setResponse(redirect(app('request')->fullUrl()));
            }
        }
    }
}
