<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Traits\DispatchableTrait;
use Anomaly\Streams\Platform\Ui\Form\Event\ValidationFailedEvent;
use Anomaly\Streams\Platform\Ui\Form\Event\ValidationPassedEvent;

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

    use DispatchableTrait;

    /**
     * Handle the command.
     *
     * @param HandleFormSubmissionValidationCommand $command
     * @return mixed
     */
    public function handle(HandleFormSubmissionValidationCommand $command)
    {
        $form = $command->getForm();

        $passes = (app()->call($form->toValidator() . '@validate', compact('form')));

        if ($passes) {

            $this->dispatch(new ValidationPassedEvent($form));
        } else {

            $this->dispatch(new ValidationFailedEvent($form));
        }

        return $passes;
    }
}
 