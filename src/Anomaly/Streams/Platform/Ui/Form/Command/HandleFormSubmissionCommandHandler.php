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

        $back = redirect(referer(url($this->request->path())));

        if (!$this->execute(new HandleFormSubmissionAuthorizationCommand($form))) {

            return $form->setResponse($back);
        }

        if (!$this->execute(new HandleFormSubmissionValidationCommand($form))) {

            return $form->setResponse($back);
        }

        return $form->setResponse($this->execute(new HandleFormSubmissionRedirectCommand($form)));
    }
}
 