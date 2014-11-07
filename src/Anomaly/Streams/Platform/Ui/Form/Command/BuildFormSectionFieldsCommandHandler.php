<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Entry\EntryInterface;
use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Ui\Form\Form;

/**
 * Class BuildFormSectionFieldsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Command
 */
class BuildFormSectionFieldsCommandHandler
{

    use CommandableTrait;

    /**
     * Create a new BuildFormSectionFieldsCommandHandler instance.
     *
     * @param BuildFormSectionFieldsCommand $command
     * @return array
     */
    public function handle(BuildFormSectionFieldsCommand $command)
    {
        $form = $command->getForm();

        $entry   = $form->getEntry();
        $utility = $form->getUtility();

        $fields = [];

        foreach ($command->getFields() as $field) {

            // Standardize the input.
            $field = $this->standardize($field);

            // Evaluate the entire row.
            // All first level closures on are gone now.
            $field = $utility->evaluate($field, [$form, $entry], $entry);

            if ($entry instanceof EntryInterface) {

                $fields[] = $this->getField($field, $form, $entry);
            }
        }

        return array_filter($fields);
    }

    /**
     * Standardize minimum input to the proper data
     * structure we actually expect.
     *
     * @param $field
     * @return array
     */
    protected function standardize($field)
    {
        /**
         * If the field is a string then
         * it is the field slug.
         */
        if (is_string($field)) {

            $field = compact('field');
        }

        return $field;
    }

    /**
     * Get field data.
     *
     * @param array          $field
     * @param Form           $form
     * @param EntryInterface $entry
     * @return array|null
     */
    protected function getField(array $field, Form $form, EntryInterface $entry)
    {
        /**
         * Get the assignment model from the field.
         * If it's not found then we'll be skipping it.
         */
        $assignment = $entry->getAssignmentFromField($field['field']);

        if ($assignment instanceof AssignmentModel) {

            $element = $this->getElement($field, $form, $entry, $assignment);

            return compact('element');
        }

        return null;
    }

    /**
     * Get the form element for a field.
     *
     * @param array           $field
     * @param Form            $form
     * @param EntryInterface  $entry
     * @param AssignmentModel $assignment
     * @return \Illuminate\View\View|null
     */
    protected function getElement(array $field, Form $form, EntryInterface $entry, AssignmentModel $assignment)
    {
        $element = '';

        foreach (setting('module.settings::available_locales', config('streams.available_locales')) as $locale) {

            if ($assignment->isTranslatable() or config('app.locale') == $locale) {

                /**
                 * If the field is being skipped make sure it never
                 * get's to the form.
                 */
                if (in_array($assignment->field->slug, $form->getSkips())) {

                    continue;
                }

                /**
                 * Get the type object spawned from the assignment
                 * next. Again if not found we're going to skip it.
                 */
                $type = $assignment->type($entry, $locale);

                /**
                 * Now that we're here set some options
                 * that might have been passed along in
                 * the configuration for the field.
                 */
                $type->setLocale($locale);
                $type->setSuffix($locale);
                $type->setPrefix($form->getPrefix());
                $type->setHidden(config('app.locale') !== $locale);

                // Only default locale required fields
                // are required. For sanity's sake.
                if (config('app.locale') != $locale) {

                    $type->setRequired(false);
                }

                // Render the input element.
                $element .= $type->element();
            }
        }

        return $element;
    }
}