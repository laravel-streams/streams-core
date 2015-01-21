<?php namespace Anomaly\Streams\Platform\Assignment;

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
     * @param  $table
     * @param  $columnName
     * @return bool
     */
    public function dropColumn($table, $columnName)
    {
        if ($this->schema->hasColumn($table, $columnName)) {
            $this->schema->table(
                $table,
                function (Blueprint $table) use ($columnName) {

                    $table->dropColumn($columnName);
                }
            );
        }

        return true;
    }

    /**
     * Add a column.
     *
     * @param      $table
     * @param      $columnName
     * @param      $columnType
     * @param bool $required
     * @param bool $unique
     */
    public function addColumn($table, $columnName, $columnType, $required = false, $unique = false)
    {
        if (!$this->schema->hasColumn($table, $columnName)) {
            $this->schema->table(
                $table,
                function (Blueprint $table) use ($columnName, $columnType, $required, $unique) {

                    $table->{$columnType}($columnName)->nullable(!$required);

                    if ($unique) {
                        $table->unique($columnName);
                    }
                }
            );
        }
    }
}
