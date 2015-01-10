<?php namespace Anomaly\Streams\Platform\Ui\Form\Command\Handler;

use Anomaly\Streams\Platform\Ui\Form\Command\SaveFormInputCommand;
use Anomaly\Streams\Platform\Ui\Form\Contract\FormHandlerInterface;

/**
 * Class SaveFormInputCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class SaveFormInputCommandHandler
{

    /**
     * Handle the command.
     *
     * @param SaveFormInputCommand $command
     */
    public function handle(SaveFormInputCommand $command)
    {
        $form = $command->getForm();

        $options = $form->getOptions();

        $handler = $options->get('handler', 'Anomaly\Streams\Platform\Ui\Form\FormHandler@handle');

        /**
         * If the handler is an instance of FormHandlerInterface
         * then just use the class as is.
         */
        if ($handler instanceof FormHandlerInterface) {
            $handler->handle($form);
        }

        /**
         * If the handler is a string or Closure then
         * we and can resolve it through the IoC container.
         */
        if (is_string($handler) || $handler instanceof \Closure) {
            app()->call($handler, compact('form'));
        }
    }
}
