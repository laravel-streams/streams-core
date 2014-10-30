<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormUtility;
use Anomaly\Streams\Platform\Entry\EntryInterface;
use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeAddon;

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
            $this->standardize($field);

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
     * @param EntryInterface $entry
     * @return array|null
     */
    protected function getField(array $field, EntryInterface $entry)
    {
        /**
         * Get the assignment model from the field.
         * If it's not found then we'll be skipping it.
         */
        $assignment = $entry->getAssignmentFromField($field['field']);

        if ($assignment instanceof AssignmentModel) {

            $element = $this->getElement($field, $entry, $assignment);

            return compact($element);

        }

        return null;
    }

    /**
     * Get the form element for a field.
     *
     * @param array           $field
     * @param EntryInterface  $entry
     * @param AssignmentModel $assignment
     * @return \Illuminate\View\View|null
     */
    protected function getElement(array $field, EntryInterface $entry, AssignmentModel $assignment)
    {
        /**
         * Get the type object spawned from the assignment
         * next. Again if not found we're going to skip it.
         */
        $type = $assignment->type($entry);

        if ($type instanceof FieldTypeAddon) {

            /**
             * Now that we're here set some options
             * that might have been passed along in
             * the configuration for the field.
             */
            $type->setLabel(trans($entry->getFieldLabel($field['field']), [], '', 'en'));
            $type->setPlaceholder(trans($entry->getFieldPlaceholder($field['field']), [], '', 'en'));

            // Render the input element.
            return $type->element();

        }

        return null;
    }

}