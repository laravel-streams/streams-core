<?php

namespace Anomaly\Streams\Platform\Addon\FieldType;

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
     * @param FieldType $fieldType
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
     * @param Blueprint $table
     * @param AssignmentInterface $assignment
     */
    public function addColumn(Blueprint $table, AssignmentInterface $assignment)
    {
        // Skip if no column type.
        if (!$type = $this->fieldType->getColumnType()) {
            return;
        }

        // Skip if the column already exists.
        if ($this->schema->hasColumn($table->getTable(), $this->fieldType->getColumnName())) {
            return;
        }

        /**
         * If the field is translatable
         * then the type becomes JSON.
         */
        if ($assignment->isTranslatable()) {
            $type = 'json';
        }

        /**
         * Add the column to the table.
         *
         * @var Blueprint|Fluent $column
         */
        $column = call_user_func_array(
            [$table, $type],
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
    }

    /**
     * Add an index for unique fields if applicable.
     *
     * @param Blueprint $table
     * @param AssignmentInterface $assignment
     */
    public function addIndex(Blueprint $table, AssignmentInterface $assignment)
    {
        $connection = $this->schema->getConnection();
        $manager    = $connection->getDoctrineSchemaManager();
        $doctrine   = $manager->listTableDetails($connection->getTablePrefix() . $table->getTable());

        $unique = md5($assignment->getId());

        if ($assignment->isUnique() && !$doctrine->hasIndex($unique)) {
            $table->unique($this->fieldType->getColumnName(), $unique);
        }
    }

    /**
     * Update the field type column to the table.
     *
     * @param Blueprint $table
     * @param AssignmentInterface $assignment
     */
    public function updateColumn(Blueprint $table, AssignmentInterface $assignment)
    {
        // Skip if no column type.
        if (!$type = $this->fieldType->getColumnType()) {
            return;
        }

        // Skip if the column doesn't exists.
        if (!$this->schema->hasColumn($table->getTable(), $this->fieldType->getColumnName())) {
            return;
        }

        /**
         * If the field is translatable
         * then the type becomes JSON.
         */
        if ($assignment->isTranslatable()) {
            $type = 'json';
        }

        /**
         * Update the column to the table.
         *
         * @var Blueprint|Fluent $column
         */
        $column = call_user_func_array(
            [$table, $type],
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
    }

    /**
     * Update the field's column index.
     *
     * @param Blueprint $table
     * @param AssignmentInterface $assignment
     */
    public function updateIndex(Blueprint $table, AssignmentInterface $assignment)
    {
        $connection = $this->schema->getConnection();
        $manager    = $connection->getDoctrineSchemaManager();
        $doctrine   = $manager->listTableDetails($connection->getTablePrefix() . $table->getTable());

        $unique = md5($assignment->getId());

        if ($assignment->isUnique() && !$assignment->isTranslatable() && !$doctrine->hasIndex($unique)) {
            $table->unique($this->fieldType->getColumnName(), $unique);
        }

        if (!$assignment->isUnique() && !$assignment->isTranslatable() && $doctrine->hasIndex($unique)) {
            $table->dropIndex($unique);
        }

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
        if (!$this->fieldType->getColumnType()) {
            return;
        }

        $table->renameColumn($from->getColumnName(), $this->fieldType->getColumnName());
    }

    /**
     * Change the column type.
     *
     * @param Blueprint $table
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

        $column->nullable(!$assignment->isRequired())->change();

        if (!str_contains($this->fieldType->getColumnType(), ['text', 'blob'])) {
            $column->default(array_get($this->fieldType->getConfig(), 'default_value'));
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
     * Drop the field's column index.
     *
     * @param Blueprint $table
     * @param AssignmentInterface $assignment
     */
    public function dropIndex(Blueprint $table, AssignmentInterface $assignment)
    {
        $connection = $this->schema->getConnection();
        $manager    = $connection->getDoctrineSchemaManager();
        $doctrine   = $manager->listTableDetails($connection->getTablePrefix() . $table->getTable());

        $unique = md5($assignment->getId());

        if ($doctrine->hasIndex($unique)) {
            $table->dropIndex($unique);
        }

        $unique = md5('unique_' . $table->getTable() . '_' . $this->fieldType->getColumnName());

        if ($doctrine->hasIndex($unique)) {
            $table->dropIndex($unique);
        }
    }

    /**
     * Backup the field type column to cache.
     *
     * @param Blueprint $table
     * @param AssignmentInterface $assignment
     */
    public function backupColumn(Blueprint $table, AssignmentInterface $assignment)
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

        $this->cache->forever(__CLASS__ . $this->fieldType->getColumnName(), $results);
    }

    /**
     * Restore the field type column to cache.
     *
     * @param Blueprint $table
     * @param AssignmentInterface $assignment
     */
    public function restoreColumn(Blueprint $table, AssignmentInterface $assignment)
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
            $result = (array) $result;

            $this->connection
                ->table($table->getTable())
                ->where('id', array_pull($result, 'id'))
                ->update($result);
        }

        $this->cache->forget(__CLASS__ . $this->fieldType->getColumnName());
    }
}
