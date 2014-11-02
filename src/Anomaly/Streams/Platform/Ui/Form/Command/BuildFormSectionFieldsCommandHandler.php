<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Entry\EntryInterface;
use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Ui\Form\FormUi;
use Anomaly\Streams\Platform\Ui\Form\FormUtility;

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
     * The form utility object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Form\FormUtility
     */
    protected $utility;

    /**
     * @param FormUtility $utility
     */
    function __construct(FormUtility $utility)
    {
        $this->utility = $utility;
    }

    /**
     * Create a new BuildFormSectionFieldsCommandHandler instance.
     *
     * @param BuildFormSectionFieldsCommand $command
     * @return array
     */
    public function handle(BuildFormSectionFieldsCommand $command)
    {
        $ui = $command->getUi();

        $entry = $ui->getEntry();

        $fields = [];

        foreach ($command->getFields() as $field) {

            // Standardize the input.
            $field = $this->standardize($field);

            // Evaluate the entire row.
            // All first level closures on are gone now.
            $field = $this->utility->evaluate($field, [$ui, $entry], $entry);

            if ($entry instanceof EntryInterface) {

                $fields[] = $this->getField($field, $ui, $entry);
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
     * @param FormUi         $ui
     * @param EntryInterface $entry
     * @return array|null
     */
    protected function getField(array $field, FormUi $ui, EntryInterface $entry)
    {
        /**
         * Get the assignment model from the field.
         * If it's not found then we'll be skipping it.
         */
        $assignment = $entry->getAssignmentFromField($field['field']);

        if ($assignment instanceof AssignmentModel) {

            $element = $this->getElement($field, $ui, $entry, $assignment);

            return compact('element');
        }

        return null;
    }

    /**
     * Get the form element for a field.
     *
     * @param array           $field
     * @param FormUi          $ui
     * @param EntryInterface  $entry
     * @param AssignmentModel $assignment
     * @return \Illuminate\View\View|null
     */
    protected function getElement(array $field, FormUi $ui, EntryInterface $entry, AssignmentModel $assignment)
    {
        $element = '';

        foreach (setting('module.settings::available_locales', ['en', 'fr']) as $locale) {

            if ($assignment->isTranslatable() or config('app.locale') == $locale) {

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
                $type->setPrefix($ui->getPrefix());
                //$type->setLabel(trans($entry->getFieldLabel($field['field']), [], '', $locale));
                $type->setPlaceholder(trans($entry->getFieldPlaceholder($field['field']), [], '', $locale));

                // Render the input element.
                $element .= $type->element();
            }
        }

        return $element;
    }
}