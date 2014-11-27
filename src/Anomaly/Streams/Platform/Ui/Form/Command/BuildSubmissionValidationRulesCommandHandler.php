<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

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
        $rules = [];

        $form = $command->getForm();

        $model  = $form->getModel();
        $entry  = $form->getEntry();
        $stream = $form->getStream();

        /**
         * If the model implements EntryInterface
         * then get the rules from it.
         * TODO: Possibly override form rules here or vice versa.
         */
        if ($model instanceof EntryInterface) {

            $rules = $model->getRules();
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
        if ($stream instanceof StreamInterface) {

            foreach ($stream->getAssignments() as $assignment) {

                $rules = $this->mergeAssignmentRule($entry, $assignment, $rules);
            }
        }

        $form->setRules($rules);
    }

    /**
     * Get assignment rules.
     *
     * @param       $fieldSlug
     * @param       $id
     * @param array $rules
     * @return array
     */
    protected function getAssignmentRules($fieldSlug, $id, array $rules)
    {
        $rules = explode('|', $rules[$fieldSlug]);

        if ($id) {

            foreach ($rules as &$rule) {

                if (starts_with($rule, 'unique:')) {

                    $rule .= ',' . $id;
                }
            }
        }

        return $rules;
    }

    /**
     * Merge in an assignment rule.
     *
     * @param EntryInterface      $entry
     * @param AssignmentInterface $assignment
     * @param array               $rules
     */
    protected function mergeAssignmentRule(EntryInterface $entry, AssignmentInterface $assignment, array $rules = [])
    {
        $fieldSlug = $assignment->getFieldSlug();

        if (isset($rules[$fieldSlug]) and $type = $assignment->getFieldType()) {

            $assignmentRules = $this->getAssignmentRules($fieldSlug, $entry->getId(), $rules);

            $rules[$fieldSlug] = implode(
                '|',
                array_merge(
                    $assignmentRules,
                    $type->getRules()
                )
            );
        }

        return $rules;
    }
}
 