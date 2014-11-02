<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

/**
 * Class HandleFormSubmissionAuthorizationCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class HandleFormSubmissionAuthorizationCommandHandler
{

    /**
     * @param HandleFormSubmissionAuthorizationCommand $command
     * @return mixed
     */
    public function handle(HandleFormSubmissionAuthorizationCommand $command)
    {
        $ui = $command->getUi();

        return (app()->call($ui->toValidator() . '@authorize', compact('ui')));
    }
}
 