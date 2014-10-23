<?php namespace Anomaly\Streams\Platform\Assignment;

class AssignmentSchema
{
    protected $schema;

    function __construct()
    {
        $this->schema = app('db')->connection()->getSchemaBuilder();
    }

    public function dropColumn($table, $columnName)
    {
        if ($this->schema->hasColumn($table, $columnName)) {

            $this->schema->table(
                $table,
                function ($table) use ($columnName) {

                    $table->dropColumn($columnName);

                }
            );

        }

        return true;
    }

    public function addColumn($table, $columnName, $columnType)
    {
        if (!$this->schema->hasColumn($table, $columnName)) {

            $this->schema->table(
                $table,
                function ($table) use ($columnName, $columnType) {

                    $table->{$columnType}($columnName)->nullable(true);

                }
            );

        }
    }
}
