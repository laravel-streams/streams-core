<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormUtility;
use Anomaly\Streams\Platform\Entry\EntryInterface;
use Anomaly\Streams\Platform\Traits\CommandableTrait;
use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeAddon;

class BuildFormSectionFieldsCommandHandler
{

    use CommandableTrait;

    protected $utility;

    function __construct(FormUtility $utility)
    {
        $this->utility = $utility;
    }

    public function handle(BuildFormSectionFieldsCommand $command)
    {
        $ui = $command->getUi();

        $entry = $ui->getEntry();

        $fields = [];

        foreach ($command->getFields() as $field) {

            /**
             * If the field is a string then
             * it is the field slug.
             */
            if (is_string($field)) {

                $field = compact('field');

            }

            // Evaluate the entire row.
            // All first level closures on are gone now.
            $field = $this->utility->evaluate($field, [$ui, $entry], $entry);

            if ($entry instanceof EntryInterface) {

                /**
                 * Get the assignment model from the field.
                 * If it's not found then we'll be skipping it.
                 */
                $assignment = $entry->getAssignmentFromField($field['field']);

                if ($assignment instanceof AssignmentModel) {

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
                        $element = $type->element();

                        $fields[] = compact('element');

                    }

                }

            }

        }

        return $fields;
    }

}