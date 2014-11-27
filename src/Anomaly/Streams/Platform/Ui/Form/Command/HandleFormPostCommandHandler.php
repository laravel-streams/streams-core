<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Traits\DispatchableTrait;
use Anomaly\Streams\Platform\Ui\Form\Event\PostedEvent;

/**
 * Class HandleFormPostCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class HandleFormPostCommandHandler
{

    use CommandableTrait;
    use DispatchableTrait;

    /**
     * Handle the command.
     *
     * @param HandleFormPostCommand $command
     */
    public function handle(HandleFormPostCommand $command)
    {
        $form = $command->getForm();

        $this->execute(new BuildSubmissionDataCommand($form));
        $this->execute(new BuildSubmissionValidationRulesCommand($form));

        /**
         * Check that the user has proper authorization
         * to submit the form.
         */
        if (!$this->execute(new HandleFormSubmissionAuthorizationCommand($form))) {

            return false;
        }

        /**
         * Check that the form passes validation.
         */
        if (!$this->execute(new HandleFormSubmissionValidationCommand($form))) {

            return false;
        }

        // We're posted!
        $this->dispatch(new PostedEvent($form));
    }
}
 