<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Support\Messages;
use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Illuminate\Http\Request;

/**
 * Class HandleFormSubmissionCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class HandleFormSubmissionCommandHandler
{

    use CommandableTrait;

    protected $request;

    protected $messages;

    function __construct(Request $request, Messages $messages)
    {
        $this->request  = $request;
        $this->messages = $messages;
    }

    /**
     * Handle the command.
     *
     * @param HandleFormSubmissionCommand $command
     */
    public function handle(HandleFormSubmissionCommand $command)
    {
        $form = $command->getForm();

        // Set a redirect to where we came from as a default.
        $back = redirect(referer(url($this->request->path())));

        /**
         * Check that the user has proper authorization
         * to submit the form.
         */
        if (!$this->execute(new HandleFormSubmissionAuthorizationCommand($form))) {

            return $form->setResponse($back);
        }

        /**
         * Check that the form passes validation.
         */
        if (!$this->execute(new HandleFormSubmissionValidationCommand($form))) {

            return $form->setResponse($back);
        }

        // Let the form submit.
        $form->fire('submit');

        // Let the intended redirect handle the.. redirect.
        return $form->setResponse($this->execute(new HandleFormSubmissionRedirectCommand($form)));
    }
}
 