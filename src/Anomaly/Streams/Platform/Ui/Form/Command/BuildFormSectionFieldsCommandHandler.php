<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
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

        $entry     = $form->getEntry();
        $expander  = $form->getExpander();
        $evaluator = $form->getEvaluator();

        $fields = [];

        foreach ($command->getFields() as $slug => $field) {

            // Expand minimum input.
            $field = $expander->expand($slug, $field);

            // Evaluate the entire row.
            // All first level closures on are gone now.
            $field = $evaluator->evaluate($field, compact('form', 'entry'), $entry);

            // Skip if disabled.
            if (!evaluate_key($field, 'enabled', true)) {

                continue;
            }

            if ($entry instanceof EntryInterface and isset($field['field'])) {

                $fields[] = $this->getField($field, $form, $entry);
            } else {

                $fields[] = $this->getFieldFromArray($slug, $field, $form);
            }
        }

        return array_filter($fields);
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
        $assignment = $entry->getAssignment($field['field']);

        if ($assignment instanceof AssignmentInterface) {

            $element = $this->getElement($field, $form, $entry, $assignment);

            return compact('element');
        }

        return null;
    }

    /**
     * Get the form element for a field.
     *
     * @param array               $field
     * @param Form                $form
     * @param EntryInterface      $entry
     * @param AssignmentInterface $assignment
     * @return \Illuminate\View\View|null
     */
    protected function getElement(array $field, Form $form, EntryInterface $entry, AssignmentInterface $assignment)
    {
        $element = '';

        foreach (setting('module.settings::available_locales', config('streams.available_locales')) as $locale) {

            $key = $form->getPrefix() . $assignment->getFieldSlug() . '_' . $locale;

            if ($assignment->isTranslatable() or config('app.locale') == $locale) {

                /**
                 * If the field is being skipped make sure it never
                 * get's to the form.
                 */
                if (in_array($assignment->getFieldSlug(), $form->getSkips())) {

                    continue;
                }

                /**
                 * Get the type object spawned from the assignment
                 * next. Again if not found we're going to skip it.
                 */
                $type = $assignment->getFieldType($entry, $locale);

                if (!$type instanceof FieldType) {

                    continue;
                }

                /**
                 * Now that we're here set some options
                 * that might have been passed along in
                 * the configuration for the field.
                 */
                $type->setLocale($locale);
                $type->setSuffix($locale);
                $type->setPrefix($form->getPrefix());
                $type->setHidden(config('app.locale') !== $locale);

                if (app('request')->has($key)) {

                    $type->setValue(app('request')->get($key));
                }

                // Only default locale required fields
                // are required. For sanity's sake.
                if (config('app.locale') != $locale) {

                    $type->setRequired(false);
                }

                // Render the input and wrapper.
                $element .= $type->render();
            }
        }

        return $element;
    }

    /**
     * Get the field from an array.
     *
     * @param       $slug
     * @param array $field
     * @param Form  $form
     * @return mixed
     */
    protected function getFieldFromArray($slug, array $field, Form $form)
    {
        $field['field'] = $slug;

        $field['prefix'] = $form->getPrefix();

        $field['suffix'] = $field['locale'] = config('app.locale');

        $type = $this->execute('Anomaly\Streams\Platform\Addon\FieldType\Command\BuildFieldTypeCommand', $field);

        return $type->render();
    }
}