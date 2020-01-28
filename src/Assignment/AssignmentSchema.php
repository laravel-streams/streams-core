<?php

namespace Anomaly\Streams\Platform\Assignment;

use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Schema\Blueprint;
use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;

/**
 * AssignmentSchema class
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AssignmentSchema
{

    /**
     * The schema builder object.
     *
     * @var Builder
     */
    protected $schema;

    /**
     * Create a new AssignmentSchema instance.
     */
    public function __construct()
    {
        $this->schema = app('db')->connection()->getSchemaBuilder();
    }

    /**
     * Add a column.
     *
     * @param AssignmentInterface $assignment
     */
    public function addColumn(AssignmentInterface $assignment)
    {
        $table  = $assignment->stream->getEntryTableName();
        $schema = $assignment->field->type->getSchema();

        $this->schema->table(
            $table,
            function (Blueprint $table) use ($schema, $assignment) {
                $schema->addColumn($table, $assignment);
            }
        );
    }

    /**
     * Add a column index.
     *
     * @param AssignmentInterface $assignment
     */
    public function addIndex(AssignmentInterface $assignment)
    {
        $table  = $assignment->stream->getEntryTableName();
        $schema = $assignment->field->type->getSchema();

        $this->schema->table(
            $table,
            function (Blueprint $table) use ($schema, $assignment) {
                $schema->addIndex($table, $assignment);
            }
        );
    }

    /**
     * Update a column.
     *
     * @param AssignmentInterface $assignment
     */
    public function updateColumn(AssignmentInterface $assignment)
    {
        $table  = $assignment->stream->getEntryTableName();
        $schema = $assignment->field->type->getSchema();

        $this->schema->table(
            $table,
            function (Blueprint $table) use ($schema, $assignment) {
                $schema->updateColumn($table, $assignment);
            }
        );
    }

    /**
     * Update a column index.
     *
     * @param AssignmentInterface $assignment
     */
    public function updateIndex(AssignmentInterface $assignment)
    {
        $table  = $assignment->stream->getEntryTableName();
        $schema = $assignment->field->type->getSchema();

        /* @var AssignmentInterface $assignment */
        $assignment = app(AssignmentRepositoryInterface::class)->find($assignment->getId());

        $assignment = clone ($assignment);

        $this->schema->table(
            $table,
            function (Blueprint $table) use ($schema, $assignment) {
                $schema->updateIndex($table, $assignment);
            }
        );
    }

    /**
     * Rename a column.
     *
     * @param AssignmentInterface $assignment
     */
    public function renameColumn(AssignmentInterface $assignment)
    {
        $columnType = $assignment->field->type->getColumnType();
        $table      = $assignment->stream->getEntryTableName();
        $schema     = $assignment->field->type->getSchema();

        /* @var AssignmentInterface $assignment */
        $assignment = app(AssignmentRepositoryInterface::class)->find($assignment->getId());

        $assignment = clone ($assignment);

        $assignment->setRelation('field', $this->field);

        $from   = $assignment->getFieldType(true);

        if ($from->getColumnName() === $columnType) {
            return;
        }

        $this->schema->table(
            $table,
            function (Blueprint $table) use ($schema, $from, $assignment) {
                $schema->renameColumn($table, $from);
                $schema->updateIndex($table, $assignment);
            }
        );
    }

    /**
     * Change a column.
     *
     * @param AssignmentInterface $assignment
     */
    public function changeColumn(AssignmentInterface $assignment)
    {
        $columnType = $assignment->field->type->getColumnType();
        $table      = $assignment->stream->getEntryTableName();
        $schema     = $assignment->field->type->getSchema();

        $from = $assignment->getFieldType(true);

        if ($from->getColumnType() === false || $columnType === false) {
            return;
        }

        if ($from->getColumnType() === $columnType) {
            return;
        }

        $this->schema->table(
            $table,
            function (Blueprint $table) use ($schema, $assignment) {
                $schema->updateColumn($table, $assignment);
            }
        );
    }

    /**
     * Drop a column.
     *
     * @param AssignmentInterface $assignment
     */
    public function dropColumn(AssignmentInterface $assignment)
    {
        if (!$assignment->stream) {
            return;
        }

        $table  = $assignment->stream->getEntryTableName();
        $schema = $assignment->field->type->getSchema();

        if (!$this->schema->hasTable($table)) {
            return;
        }

        $this->schema->table(
            $table,
            function (Blueprint $table) use ($schema) {
                $schema->dropColumn($table);
            }
        );
    }

    /**
     * Drop a column index.
     *
     * @param AssignmentInterface $assignment
     */
    public function dropIndex(AssignmentInterface $assignment)
    {
        if (!$assignment->stream) {
            return;
        }

        $table  = $assignment->stream->getEntryTableName();
        $schema = $assignment->field->type->getSchema();

        if (!$this->schema->hasTable($table)) {
            return;
        }

        $this->schema->table(
            $table,
            function (Blueprint $table) use ($schema, $assignment) {
                $schema->dropIndex($table, $assignment);
            }
        );
    }

    /**
     * Backup a column's data.
     *
     * @param AssignmentInterface $assignment
     */
    public function backupColumn(AssignmentInterface $assignment)
    {
        $table  = $assignment->stream->getEntryTableName();
        $schema = $assignment->field->type->getSchema();

        if (!$this->schema->hasTable($table)) {
            return;
        }

        $this->schema->table(
            $table,
            function (Blueprint $table) use ($schema, $assignment) {
                $schema->backupColumn($table, $assignment);
            }
        );
    }

    /**
     * Restore a column's data.
     *
     * @param AssignmentInterface $assignment
     */
    public function restoreColumn(AssignmentInterface $assignment)
    {
        $table  = $assignment->stream->getEntryTableName();
        $schema = $assignment->field->type->getSchema();

        if (!$this->schema->hasTable($table)) {
            return;
        }

        $this->schema->table(
            $table,
            function (Blueprint $table) use ($schema, $assignment) {
                $schema->restoreColumn($table, $assignment);
            }
        );
    }
}
