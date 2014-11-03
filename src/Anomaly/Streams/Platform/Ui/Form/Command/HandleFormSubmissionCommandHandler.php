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
        $ui = $command->getUi();

        $back = redirect(referer(url($this->request->path())));

        if (!$this->execute(new HandleFormSubmissionAuthorizationCommand($ui))) {

            return $ui->setResponse($back);
        }

        if (!$this->execute(new HandleFormSubmissionValidationCommand($ui))) {

            return $ui->setResponse($back);
        }

        return $ui->setResponse($this->execute(new HandleFormSubmissionRedirectCommand($ui)));
    }
}
 