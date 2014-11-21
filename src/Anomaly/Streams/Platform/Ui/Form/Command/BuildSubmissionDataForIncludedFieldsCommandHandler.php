<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\Form;

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
     */
    public function handle(BuildSubmissionDataForIncludedFieldsCommand $command)
    {
        $form = $command->getForm();

        foreach ($form->getInclude() as $input) {

            $this->addIncludedInput($form, $input);
        }
    }

    /**
     * Add an included input to the input data.
     *
     * @param Form $form
     * @param      $input
     */
    protected function addIncludedInput(Form $form, $input)
    {
        $key = $form->getPrefix() . $input . '_en'; //TODO: Fix this.. seems dumb.

        $form->addInput('include', $input, app('request')->get($key));
    }
}
 