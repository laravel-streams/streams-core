<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

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
        $ui = $command->getUi();

        return (app()->call($ui->toValidator() . '@validate', compact('ui')));
    }
}
 