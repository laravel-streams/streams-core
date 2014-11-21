<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Ui\Form\Form;

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
     */
    public function handle(BuildSubmissionDataForTranslationsCommand $command)
    {
        $form = $command->getForm();

        $stream = $form->getStream();

        if ($stream instanceof StreamInterface) {

            foreach (setting('module.settings::available_locales', config('streams.available_locales')) as $locale) {

                if ($stream->isTranslatable() or config('app.locale') != $locale) {

                    foreach ($stream->getAssignments() as $assignment) {

                        $this->addAssignmentInput($form, $assignment, $locale);
                    }
                }
            }
        }
    }

    /**
     * Get the key for the field's post data.
     *
     * @param Form                $form
     * @param AssignmentInterface $assignment
     * @param                     $locale
     * @return string
     */
    protected function getKey(Form $form, AssignmentInterface $assignment, $locale)
    {
        return $form->getPrefix() . $assignment->getFieldSlug() . '_' . $locale;
    }

    /**
     * Add an assignment input.
     *
     * @param Form                $form
     * @param AssignmentInterface $assignment
     * @param                     $locale
     */
    protected function addAssignmentInput(Form $form, AssignmentInterface $assignment, $locale)
    {
        if ($assignment->isTranslatable()) {

            $key = $this->getKey($form, $assignment, $locale);

            $fieldSlug = $assignment->getFieldSlug();

            if (!in_array($fieldSlug, $form->getSkips())) {

                $form->addInput($locale, $fieldSlug, app('request')->get($key));
            }
        }
    }
}
 