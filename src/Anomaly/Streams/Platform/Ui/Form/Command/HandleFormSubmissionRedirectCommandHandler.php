<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Illuminate\Http\Request;

/**
 * Class HandleFormSubmissionRedirectCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class HandleFormSubmissionRedirectCommandHandler
{

    /**
     * Handle the command.
     *
     * @param HandleFormSubmissionRedirectCommand $command
     * @param Request                             $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handle(HandleFormSubmissionRedirectCommand $command, Request $request)
    {
        $form = $command->getForm();

        return redirect($request->get($form->getPrefix() . 'redirect'));
    }
}
 