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

        $model  = $form->getModel();
        $stream = $form->getStream();

        $rules = $model::$rules;

        /**
         * Remove skips from validation entirely.
         */
        foreach ($form->getSkips() as $field) {

            unset($rules[$field]);
        }

        /**
         * Merge in field type rules.
         */
        foreach ($stream->assignments as $assignment) {

            if (isset($rules[$assignment->field->slug]) and $type = $assignment->type()) {


                $rules[$assignment->field->slug] = implode(
                    '|',
                    array_merge(
                        explode('|', $rules[$assignment->field->slug]),
                        $type->getRules()
                    )
                );
            }
        }

        $form->setRules($rules);
    }
}
 