<?php namespace Anomaly\Streams\Platform\Ui\Form\Command\Handler;

use Anomaly\Streams\Platform\Ui\Form\Command\ValidateFormInput;
use Anomaly\Streams\Platform\Ui\Form\Contract\FormValidatorInterface;

/**
 * Class ValidateFormInputHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class ValidateFormInputHandler
{

    /**
     * Handle the command.
     *
     * @param ValidateFormInput $command
     */
    public function handle(ValidateFormInput $command)
    {
        $form = $command->getForm();

        $options = $form->getOptions();

        $validator = $options->get('validator', 'Anomaly\Streams\Platform\Ui\Form\FormValidator@validate');

        /**
         * If the validator is an instance of FormValidatorInterface
         * then just use the class as is.
         */
        if ($validator instanceof FormValidatorInterface) {
            $validator->validate($form);
        }

        /**
         * If the validator is a string or Closure then it's a handler
         * and we and can resolve it through the IoC container.
         */
        if (is_string($validator) || $validator instanceof \Closure) {
            app()->call($validator, compact('form'));
        }
    }
}
