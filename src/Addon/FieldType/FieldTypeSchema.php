<?php namespace Anomaly\Streams\Platform\Addon\FieldType;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Fluent;

/**
 * Class FieldTypeSchema
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class FieldTypeSchema
{

    /**
     * The cache repository.
     *
     * @var Repository
     */
    protected $cache;

    /**
     * The schema builder object.
     *
     * @var Builder
     */
    protected $schema;

    /**
     * The service container.
     *
     * @var Container
     */
    protected $container;

    /**
     * The database connection.
     *
     * @var Connection
     */
    protected $connection;

    /**
     * The field type object.
     *
     * @var FieldType
     */
    protected $fieldType;

    /**
     * Create a new FieldTypeSchema instance.
     *
     * @param FieldType  $fieldType
     * @param Repository $cache
     */
    public function __construct(FieldType $fieldType, Container $container, Repository $cache)
    {
        $this->cache     = $cache;
        $this->container = $container;
        $this->fieldType = $fieldType;

        $this->connection = $container->make('db')->connection();

        $this->schema = $this->connection->getSchemaBuilder();
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
                    $this->fieldType->getColumnLength(),
                ]
            )
        );

        $column->nullable(!$assignment->isTranslatable() ? !$assignment->isRequired() : true);

        if (!str_contains($this->fieldType->getColumnType(), ['text', 'blob'])) {
            $column->default(array_get($this->fieldType->getConfig(), 'default_value'));
        }

        // Mark the column unique if it's unique AND not translatable.
        if ($assignment->isUnique() && !$assignment->isTranslatable()) {
            $table->unique(
                $this->fieldType->getColumnName(),
                md5($assignment->getId())
            );
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
                    $this->fieldType->getColumnLength(),
                ]
            )
        );

        $column->nullable(!$assignment->isTranslatable() ? !$assignment->isRequired() : true)->change();

        if (!str_contains($this->fieldType->getColumnType(), ['text', 'blob'])) {
            $column->default(array_get($this->fieldType->getConfig(), 'default_value'));
        }

        /*
         * Mark the column unique if desired and not translatable.
         * Otherwise, drop the unique index.
         */
        $connection = $this->schema->getConnection();
        $manager    = $connection->getDoctrineSchemaManager();
        $doctrine   = $manager->listTableDetails($connection->getTablePrefix() . $table->getTable());

        // The unique index name.
        $unique = md5($assignment->getId());

        /*
         * If the assignment is unique and not translatable
         * and the table does not already have the given the
         * given table index then go ahead and add it.
         */
        if ($assignment->isUnique() && !$assignment->isTranslatable() && !$doctrine->hasIndex($unique)) {
            $table->unique($this->fieldType->getColumnName(), $unique);
        }

        /*
         * If the assignment is NOT unique and not translatable
         * and the table DOES have the given table index
         * then we need to remove.
         */
        if (!$assignment->isUnique() && !$assignment->isTranslatable() && $doctrine->hasIndex($unique)) {
            $table->dropIndex($unique);
        }

        /*
         * @deprecated Will be removed in 3.5
         *
         * If the assignment is NOT unique and not translatable
         * and the table DOES have the given table index
         * then we need to remove.
         */
        $unique = md5('unique_' . $table->getTable() . '_' . $this->fieldType->getColumnName());

        if (!$assignment->isUnique() && !$assignment->isTranslatable() && $doctrine->hasIndex($unique)) {
            $table->dropIndex($unique);
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
     * Change the column type.
     *
     * @param Blueprint           $table
     * @param AssignmentInterface $assignment
     */
    public function changeColumn(Blueprint $table, AssignmentInterface $assignment)
    {
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
                    $this->fieldType->getColumnLength(),
                ]
            )
        );

        $column->nullable(!$assignment->isTranslatable() ? !$assignment->isRequired() : true)->change();

        if (!str_contains($this->fieldType->getColumnType(), ['text', 'blob'])) {
            $column->default(array_get($this->fieldType->getConfig(), 'default_value'));
        }

        /*
         * Mark the column unique if desired and not translatable.
         * Otherwise, drop the unique index.
         */
        $connection = $this->schema->getConnection();
        $manager    = $connection->getDoctrineSchemaManager();
        $doctrine   = $manager->listTableDetails($connection->getTablePrefix() . $table->getTable());

        // The unique index name.
        $unique = md5($assignment->getId());

        /*
         * If the assignment is unique and not translatable
         * and the table does not already have the given the
         * given table index then go ahead and add it.
         */
        if ($assignment->isUnique() && !$assignment->isTranslatable() && !$doctrine->hasIndex($unique)) {
            $table->unique($this->fieldType->getColumnName(), $unique);
        }

        /*
         * If the assignment is NOT unique and not translatable
         * and the table DOES have the given table index
         * then we need to remove.
         */
        if (!$assignment->isUnique() && !$assignment->isTranslatable() && $doctrine->hasIndex($unique)) {
            $column->dropIndex($unique);
        }
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

    /**
     * Backup the field type column to cache.
     *
     * @param Blueprint $table
     */
    public function backupColumn(Blueprint $table)
    {
        // Skip if no column type.
        if (!$this->fieldType->getColumnType()) {
            return;
        }

        // Skip if the column doesn't exist.
        if (!$this->schema->hasColumn($table->getTable(), $this->fieldType->getColumnName())) {
            return;
        }
        // Back dat data up.
        $results = $this->connection
            ->table($table->getTable())
            ->select(['id', $this->fieldType->getColumnName()])
            ->get();

        $this->cache->put(__CLASS__ . $this->fieldType->getColumnName(), $results, 10);
    }

    /**
     * Restore the field type column to cache.
     *
     * @param Blueprint $table
     */
    public function restoreColumn(Blueprint $table)
    {
        // Skip if no column type.
        if (!$this->fieldType->getColumnType()) {
            return;
        }

        // Skip if the column doesn't exist.
        if (!$this->schema->hasColumn($table->getTable(), $this->fieldType->getColumnName())) {
            return;
        }

        // Translatable or no?
        $translatable = ends_with($table->getTable(), '_translations');

        // Restore the data.
        $results = $this->cache->get(__CLASS__ . $this->fieldType->getColumnName());

        foreach ($results as $result) {
            $result = (array)$result;

            $this->connection
                ->table($table->getTable())
                ->where($translatable ? 'entry_id' : 'id', array_pull($result, 'id'))
                ->update($result);
        }

        $this->cache->forget(__CLASS__ . $this->fieldType->getColumnName());
    }
}
