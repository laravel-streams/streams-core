<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Stream\StreamModel;
use Anomaly\Streams\Platform\Ui\Form\Form;

/**
 * Class BuildSubmissionDataForDefaultLocaleCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class BuildSubmissionDataForDefaultLocaleCommandHandler
{

    /**
     * Handle the command.
     *
     * @param BuildSubmissionDataForDefaultLocaleCommand $command
     */
    public function handle(BuildSubmissionDataForDefaultLocaleCommand $command)
    {
        $form = $command->getForm();

        $stream = $form->getStream();

        if ($stream instanceof StreamModel) {

            foreach ($stream->getAssignments() as $assignment) {

                $this->addAssignmentInput($form, $assignment);
            }
        }
    }

    /**
     * Add input for an assignment.
     *
     * @param Form                $form
     * @param AssignmentInterface $assignment
     */
    protected function addAssignmentInput(Form $form, AssignmentInterface $assignment)
    {
        $fieldSlug = $assignment->getFieldSlug();

        if (!in_array($fieldSlug, $form->getSkips())) {

            $form->addInput(config('app.locale'), $fieldSlug, app('request')->get($this->getKey($form, $assignment)));
        }
    }

    /**
     * Generate the post key for an assigned field.
     *
     * @param Form                $form
     * @param AssignmentInterface $assignment
     * @return string
     */
    protected function getKey(Form $form, AssignmentInterface $assignment)
    {
        return $form->getPrefix() . $assignment->getFieldSlug() . '_' . config('app.locale');
    }
}
 