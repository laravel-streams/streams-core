<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Illuminate\Http\Request;

/**
 * Class BuildSubmissionDataForIncludedFieldsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class BuildSubmissionDataForIncludedFieldsCommandHandler
{

    /**
     * Handle the command.
     *
     * @param BuildSubmissionDataForIncludedFieldsCommand $command
     * @param Request                                     $request
     */
    public function handle(BuildSubmissionDataForIncludedFieldsCommand $command, Request $request)
    {
        $form = $command->getForm();

        foreach ($form->getInclude() as $include) {

            $key = $form->getPrefix() . $include . '_en'; //TODO: Fix this..

            $form->addData('include', $include, $request->get($key));
        }
    }
}
 