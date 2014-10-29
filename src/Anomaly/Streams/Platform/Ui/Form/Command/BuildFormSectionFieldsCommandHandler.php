<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeAddon;
use Anomaly\Streams\Platform\Assignment\AssignmentModel;
use Anomaly\Streams\Platform\Entry\EntryInterface;
use Anomaly\Streams\Platform\Ui\Form\FormUtility;
use Anomaly\Streams\Platform\Traits\CommandableTrait;

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

                $assignment = $entry->getAssignmentFromField($field['field']);

                if ($assignment instanceof AssignmentModel) {

                    $type = $assignment->type($entry);

                    if ($type instanceof FieldTypeAddon) {

                        // Set the label
                        $type->setLabel(trans($entry->getFieldLabel($field['field']), [], '', 'en'));

                        $element = $type->element();

                        $fields[] = compact('element');

                    }

                }

            }

            return $fields;
        }
    }

}