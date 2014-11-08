<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Ui\Form\Form;
use Illuminate\Http\Request;

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
     * @param Request                                    $request
     */
    public function handle(BuildSubmissionDataForDefaultLocaleCommand $command, Request $request)
    {
        $form = $command->getForm();

        $stream = $form->getStream();

        foreach ($stream->assignments as $assignment) {

            if ($field = $assignment->field->slug and !in_array($field, $form->getSkips())) {

                $form->addData(config('app.locale'), $field, $request->get($this->getKey($form, $assignment)));
            }
        }
    }

    /**
     * Generate the post key for an assigned field.
     *
     * @param Form            $form
     * @param AssignmentModel $assignment
     * @return string
     */
    protected function getKey(Form $form, AssignmentModel $assignment)
    {
        return $form->getPrefix() . $assignment->field->slug . '_' . config('app.locale');
    }
}
 