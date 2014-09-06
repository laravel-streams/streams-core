<?php namespace Streams\Core\Assignment\Schema;

use Streams\Core\Assignment\Model\AssignmentModel;

class AssignmentSchema
{
    /**
     * The model object.
     *
     * @var \Streams\Core\Assignment\Model\AssignmentModel
     */
    protected $model;

    /**
     * Create a new AssignmentSchema instance.
     *
     * @param AssignmentModel $model
     */
    public function __construct(AssignmentModel $model)
    {
        $this->model = $model;
    }

    /**
     * Create the assignment column.
     *
     * @return bool
     */
    public function create()
    {
        $assignment = $this->model;

        $fieldType = $assignment->field->type->setAssignment($assignment);

        $columnName = $fieldType->columnName();

        $entryTable = $assignment->stream->entryTable();

        $translatableTable = $assignment->stream->translatableTable();

        $columnTypeMethod = camel_case($fieldType->getColumnType());

        $constraint = $this->getColumnConstraint($assignment);

        $defaultValue = $assignment->field->getSetting('default_value');

        if (\Schema::hasColumn($entryTable, $columnName)) {
            $this->addColumn(
                $entryTable,
                $assignment,
                $fieldType,
                $columnName,
                $columnTypeMethod,
                $constraint,
                $defaultValue
            );
        }

        if ($assignment->stream->is_translatable and $assignment->is_translatable) {
            if (\Schema::hasColumn($translatableTable, $columnName)) {
                $this->addColumn(
                    $translatableTable,
                    $assignment,
                    $fieldType,
                    $columnName,
                    $columnTypeMethod,
                    $constraint,
                    $defaultValue
                );
            }
        }

        return true;
    }

    public function update()
    {
        // @todo - Finish this.
    }

    /**
     * Delete the assignment column.
     *
     * @return bool
     */
    public function delete()
    {
        $assignment = $this->model;

        $fieldType = $assignment->field->type->setAssignment($assignment);

        $columnName = $fieldType->columnName();

        $entryTable = $assignment->stream->entryTable();

        $translatableTable = $assignment->stream->translatableTable();

        if (\Schema::hasColumn($entryTable, $columnName)) {
            \Schema::table(
                $entryTable,
                function ($table) use ($columnName) {
                    $table->dropColumn($columnName);
                }
            );
        }

        if ($assignment->stream->is_translatable and $assignment->is_translatable) {
            if (\Schema::hasColumn($translatableTable, $columnName)) {
                \Schema::table(
                    $translatableTable,
                    function ($table) use ($columnName) {
                        $table->dropColumn($columnName);
                    }
                );
            }
        }

        return true;
    }

    /**
     * Add a column to a table.
     *
     * @param $table
     * @param $assignment
     * @param $fieldType
     * @param $columnName
     * @param $columnTypeMethod
     * @param $constraint
     * @param $defaultValue
     * @return bool
     */
    protected function addColumn(
        $table,
        $assignment,
        $fieldType,
        $columnName,
        $columnTypeMethod,
        $constraint,
        $defaultValue
    ) {
        \Schema::table(
            $table,
            function ($table) use (
                $assignment,
                $fieldType,
                $columnName,
                $columnTypeMethod,
                $constraint,
                $defaultValue
            ) {

                // Only the string method cares about a constraint
                if ($columnTypeMethod === 'string' and $constraint) {
                    $column = $table->{$columnTypeMethod}($columnName, $constraint);
                } else {
                    $column = $table->{$columnTypeMethod}($columnName);
                }

                $column->default($defaultValue);

                $column->nullable(true);
            }
        );

        return true;
    }

    /**
     * Get the column constraint for an assignment.
     *
     * @param AssignmentModel $assignment
     * @return int|string
     */
    protected function getColumnConstraint(AssignmentModel $assignment)
    {
        $constraint = 255;

        $maxLength = $assignment->field->getSetting('max_length');
        $fieldType = $assignment->field->type;

        if ($constraint = $fieldType->getColumnConstraint()) {
            // Use the column constraint.
        } elseif (is_numeric($maxLength) and $constraint = $maxLength) {
            // Use the maxlength value.
        }

        return $constraint;
    }
}
