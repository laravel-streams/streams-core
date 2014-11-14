<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Stream\StreamModel;
use Anomaly\Streams\Platform\Ui\Form\Form;
use Illuminate\Http\Request;

/**
 * Class BuildSubmissionDataForTranslationsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class BuildSubmissionDataForTranslationsCommandHandler
{

    /**
     * Handle the command.
     *
     * @param BuildSubmissionDataForTranslationsCommand $command
     * @param Request                                   $request
     */
    public function handle(BuildSubmissionDataForTranslationsCommand $command, Request $request)
    {
        $form = $command->getForm();

        $stream = $form->getStream();

        if ($stream instanceof StreamModel) {

            foreach (setting('module.settings::available_locales', config('streams.available_locales')) as $locale) {

                if ($stream->isTranslatable() or config('app.locale') != $locale) {

                    foreach ($stream->assignments as $assignment) {

                        if ($assignment->isTranslatable()) {

                            $key = $this->getKey($form, $assignment, $locale);

                            if ($field = $assignment->field->slug and !in_array($field, $form->getSkips())) {

                                $form->addData($locale, $field, $request->get($key));
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * Get the key for the field's post data.
     *
     * @param Form            $form
     * @param AssignmentModel $assignment
     * @param                 $locale
     * @return string
     */
    protected function getKey(Form $form, AssignmentModel $assignment, $locale)
    {
        return $form->getPrefix() . $assignment->field->slug . '_' . $locale;
    }
}
 