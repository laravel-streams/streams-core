<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Contract\FormValidatorInterface;
use Anomaly\Streams\Platform\Ui\Form\Form;

/**
 * Class HandleFormSubmissionValidationCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class HandleFormSubmissionValidationCommandHandler
{

    /**
     * Handle the command.
     *
     * @param HandleFormSubmissionValidationCommand $command
     * @return mixed
     */
    public function handle(HandleFormSubmissionValidationCommand $command)
    {
        $form = $command->getForm();

        return $this->runValidator($form->newValidator(), $form);
    }

    /**
     * Run the validator.
     *
     * @param FormValidatorInterface $validator
     * @param Form                   $form
     * @return bool
     */
    protected function runValidator(FormValidatorInterface $validator, Form $form)
    {
        return (bool)$validator->validate($form);
    }
}
 