<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Contract\FormValidatorInterface;

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

        return $this->runValidator($form->newValidator());
    }

    /**
     * Run the validator.
     *
     * @param FormValidatorInterface $validator
     * @return bool
     */
    protected function runValidator(FormValidatorInterface $validator)
    {
        return (bool)$validator->validate();
    }
}
 