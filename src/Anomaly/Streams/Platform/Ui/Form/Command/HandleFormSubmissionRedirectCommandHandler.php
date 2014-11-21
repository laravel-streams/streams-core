<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handle(HandleFormSubmissionRedirectCommand $command)
    {
        $form = $command->getForm();

        return redirect(app('request')->get($form->getPrefix() . 'redirect'));
    }
}
 