<?php namespace Anomaly\Streams\Platform\Ui\Form\Command\Handler;

use Anomaly\Streams\Platform\Ui\Form\Command\SaveFormInput;
use Anomaly\Streams\Platform\Ui\Form\Contract\FormHandlerInterface;

/**
 * Class SaveFormInputHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class SaveFormInputHandler
{

    /**
     * Handle the command.
     *
     * @param SaveFormInput $command
     */
    public function handle(SaveFormInput $command)
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
