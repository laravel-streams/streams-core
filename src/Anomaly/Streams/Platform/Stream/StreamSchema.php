<?php namespace Anomaly\Streams\Platform\Stream;

class StreamSchema
{
    protected $schema;

    public function __construct()
    {
        $this->schema = app('db')->connection()->getSchemaBuilder();
    }

    public function createTable($table)
    {
        $this->schema->dropIfExists($table);

        $this->schema->create(
            $table,
            function ($table) {

                $table->increments('id');
                $table->integer('sort_order')->nullable();
                $table->datetime('created_at');
                $table->integer('created_by')->nullable();
                $table->datetime('updated_at')->nullable();
                $table->integer('updated_by')->nullable();

            }
        );
    }

    public function createTranslationsTable($table)
    {
        $this->schema->dropIfExists($table);

        $this->schema->create(
            $table,
            function ($table) {

                $table->increments('id');
                $table->string('iso')->nullable();

            }
        );
    }
}
