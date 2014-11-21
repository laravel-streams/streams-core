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

            $this->addTranslatedInputs($form, $stream);
        }
    }

    /**
     * Add translated inputs to the form input.
     *
     * @param Form            $form
     * @param StreamInterface $stream
     */
    protected function addTranslatedInputs(Form $form, StreamInterface $stream)
    {
        foreach (setting('module.settings::available_locales', config('streams.available_locales')) as $locale) {

            if ($stream->isTranslatable() or config('app.locale') != $locale) {

                $this->addTranslatedAssignmentInputs($form, $stream, $locale);
            }
        }
    }

    /**
     * Add translated assignment inputs to the form input.
     *
     * @param Form            $form
     * @param StreamInterface $stream
     * @param                 $locale
     */
    protected function addTranslatedAssignmentInputs(Form $form, StreamInterface $stream, $locale)
    {
        foreach ($stream->getAssignments() as $assignment) {

            $this->addAssignmentInput($form, $assignment, $locale);
        }
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

            $fieldSlug = $assignment->getFieldSlug();

            if (!in_array($fieldSlug, $form->getSkips())) {

                $form->addInput($locale, $fieldSlug, $this->getAssignmentInputValue($form, $assignment, $locale));
            }
        }
    }

    /**
     * Get the assignment's input value.
     *
     * @param Form                $form
     * @param AssignmentInterface $assignment
     * @param                     $locale
     * @return mixed
     */
    protected function getAssignmentInputValue(Form $form, AssignmentInterface $assignment, $locale)
    {
        return app('request')->get($key = $this->getKey($form, $assignment, $locale));
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
}
 