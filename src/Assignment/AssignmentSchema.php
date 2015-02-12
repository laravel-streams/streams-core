<?php namespace Anomaly\Streams\Platform\Assignment;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

/**
 * Class AssignmentSchema
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Assignment
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
     * Drop a column.
     *
     * @param                     $table
     * @param FieldType           $type
     * @param AssignmentInterface $assignment
     */
    public function dropColumn($table, FieldType $type, AssignmentInterface $assignment)
    {
        $schema = $type->getSchema();

        $this->schema->table(
            $table,
            function (Blueprint $table) use ($schema, $assignment) {
                $schema->dropColumn($table, $assignment);
            }
        );
    }

    /**
     * Add a column.
     *
     * @param                     $table
     * @param FieldType           $type
     * @param AssignmentInterface $assignment
     */
    public function addColumn($table, FieldType $type, AssignmentInterface $assignment)
    {
        $schema = $type->getSchema();

        $this->schema->table(
            $table,
            function (Blueprint $table) use ($schema, $assignment) {
                $schema->addColumn($table, $assignment);
            }
        );
    }
}
