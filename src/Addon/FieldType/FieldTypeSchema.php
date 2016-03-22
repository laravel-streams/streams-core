<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Fluent;

/**
 * Class FieldTypeSchema
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon\FieldType
 */
class FieldTypeSchema
{

    /**
     * The schema builder object.
     *
     * @var Builder
     */
    protected $schema;

    /**
     * The field type object.
     *
     * @var FieldType
     */
    protected $fieldType;

    /**
     * Create a new FieldTypeSchema instance.
     *
     * @param FieldType $fieldType
     */
    public function __construct(FieldType $fieldType)
    {
        $this->fieldType = $fieldType;

        $this->schema = app('db')->connection()->getSchemaBuilder();
    }

    /**
     * Add the field type column to the table.
     *
     * @param Blueprint           $table
     * @param AssignmentInterface $assignment
     */
    public function addColumn(Blueprint $table, AssignmentInterface $assignment)
    {
        // Skip if no column type.
        if (!$this->fieldType->getColumnType()) {
            return;
        }

        // Skip if the column already exists.
        if ($this->schema->hasColumn($table->getTable(), $this->fieldType->getColumnName())) {
            return;
        }

        /**
         * Add the column to the table.
         *
         * @var Blueprint|Fluent $column
         */
        $column = call_user_func_array(
            [$table, $this->fieldType->getColumnType()],
            array_filter(
                [
                    $this->fieldType->getColumnName(),
                    $this->fieldType->getColumnLength()
                ]
            )
        );

        $column->nullable(!$assignment->isTranslatable() ? !$assignment->isRequired() : true);

        if (!str_contains($this->fieldType->getColumnType(), ['text', 'blob'])) {
            $column->default(array_get($this->fieldType->getConfig(), 'default_value'));
        }

        // Mark the column unique if it's unique AND not translatable.
        if ($assignment->isUnique() && !$assignment->isTranslatable()) {
            $table->unique($this->fieldType->getColumnName(), md5('unique_' . $this->fieldType->getColumnName()));
        }
    }

    /**
     * Update the field type column to the table.
     *
     * @param Blueprint           $table
     * @param AssignmentInterface $assignment
     */
    public function updateColumn(Blueprint $table, AssignmentInterface $assignment)
    {
        // Skip if no column type.
        if (!$this->fieldType->getColumnType()) {
            return;
        }

        // Skip if the column doesn't exists.
        if (!$this->schema->hasColumn($table->getTable(), $this->fieldType->getColumnName())) {
            return;
        }

        /**
         * Update the column to the table.
         *
         * @var Blueprint|Fluent $column
         */
        $column = call_user_func_array(
            [$table, $this->fieldType->getColumnType()],
            array_filter(
                [
                    $this->fieldType->getColumnName(),
                    $this->fieldType->getColumnLength()
                ]
            )
        );

        $column->nullable(!$assignment->isTranslatable() ? !$assignment->isRequired() : true)->change();

        if (!str_contains($this->fieldType->getColumnType(), ['text', 'blob'])) {
            $column->default(array_get($this->fieldType->getConfig(), 'default_value'));
        }

        /**
         * Mark the column unique if desired and not translatable.
         * Otherwise, drop the unique index.
         */
        $connection = $this->schema->getConnection();
        $manager    = $connection->getDoctrineSchemaManager();
        $doctrine   = $manager->listTableDetails($connection->getTablePrefix() . $table->getTable());

        // The unique index name.
        $unique = md5('unique_' . $this->fieldType->getColumnName());

        /**
         * If the assignment is unique and not translatable
         * and the table does not already have the given the
         * given table index then go ahead and add it.
         */
        if ($assignment->isUnique() && !$assignment->isTranslatable() && !$doctrine->hasIndex($unique)) {
            $table->unique($this->fieldType->getColumnName(), $unique);
        }

        /**
         * If the assignment is NOT unique and not translatable
         * and the table DOES have the given table index
         * then we need to remove.
         */
        if (!$assignment->isUnique() && !$assignment->isTranslatable() && $doctrine->hasIndex($unique)) {
            $column->dropIndex(md5('unique_' . $this->fieldType->getColumnName()));
        }
    }

    /**
     * Rename the column.
     *
     * @param Blueprint $table
     * @param FieldType $from
     */
    public function renameColumn(Blueprint $table, FieldType $from)
    {
        $table->renameColumn($from->getColumnName(), $this->fieldType->getColumnName());
    }

    /**
     * Drop the field type column from the table.
     *
     * @param Blueprint $table
     */
    public function dropColumn(Blueprint $table)
    {
        // Skip if no column type.
        if (!$this->fieldType->getColumnType()) {
            return;
        }

        // Skip if the column doesn't exist.
        if (!$this->schema->hasColumn($table->getTable(), $this->fieldType->getColumnName())) {
            return;
        }

        // Drop dat 'ole column.
        $table->dropColumn($this->fieldType->getColumnName());
    }
}
