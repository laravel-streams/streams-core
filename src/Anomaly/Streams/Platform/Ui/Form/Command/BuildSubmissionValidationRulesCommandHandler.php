<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Entry\EntryInterface;
use Anomaly\Streams\Platform\Stream\StreamModel;

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
        $entry  = $form->getEntry();
        $stream = $form->getStream();

        $rules = [];

        if ($stream instanceof StreamModel) {

            $rules = $model::$rules;
        }

        /**
         * Remove skips from validation entirely.
         */
        foreach ($form->getSkips() as $field) {

            unset($rules[$field]);
        }

        /**
         * Merge in field type rules.
         */
        if ($stream instanceof StreamModel) {

            foreach ($stream->assignments as $assignment) {

                if (isset($rules[$assignment->field->slug]) and $type = $assignment->type()) {

                    $assignmentRules = $this->getAssignmentRules($entry, $assignment, $rules);

                    $rules[$assignment->field->slug] = implode(
                        '|',
                        array_merge(
                            $assignmentRules,
                            $type->getRules()
                        )
                    );
                }
            }
        }

        $form->setRules($rules);
    }

    protected function getAssignmentRules(EntryInterface $entry, AssignmentModel $assignment, array $rules)
    {
        $rules = explode('|', $rules[$assignment->field->slug]);

        if ($id = $entry->getKey()) {

            foreach ($rules as &$rule) {

                if (starts_with($rule, 'unique:')) {

                    $rule .= ',' . $id;
                }
            }
        }

        return $rules;
    }
}
 