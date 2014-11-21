<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Contract\FormAuthorityInterface;

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
     * Handle the command.
     *
     * @param HandleFormSubmissionAuthorizationCommand $command
     * @return mixed
     */
    public function handle(HandleFormSubmissionAuthorizationCommand $command)
    {
        $form = $command->getForm();

        return $this->runAuthorization($form->newAuthority());
    }

    /**
     * Run the authorization.
     *
     * @param FormAuthorityInterface $authority
     * @return bool
     */
    protected function runAuthorization(FormAuthorityInterface $authority)
    {
        return (bool)$authority->authorize();
    }
}
 