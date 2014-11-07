<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

/**
 * Class BuildSubmissionValidationRulesCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class BuildSubmissionValidationRulesCommandHandler
{

    /**
     * Handle the command.
     *
     * @param BuildSubmissionValidationRulesCommand $command
     */
    public function handle(BuildSubmissionValidationRulesCommand $command)
    {
        $form = $command->getForm();

        $model = $form->getModel();

        $rules = $model::$rules;

        foreach ($form->getSkips() as $field) {

            unset($rules[$field]);
        }

        $form->setRules($rules);
    }
}
 