<?php namespace Anomaly\Streams\Platform\Stream\Command;

use Anomaly\Streams\Platform\Stream\StreamSchema;

class CreateStreamsEntryTableCommandHandler
{
    protected $schema;

    function __construct(StreamSchema $schema)
    {
        $this->schema = $schema;
    }

    public function handle(CreateStreamsEntryTableCommand $command)
    {
        $stream = $command->getStream();

        $table = $stream->getEntryTableName();

        $this->schema->createTable($table);

        if ($stream->is_translatable) {

            $table = $stream->getEntryTranslationsTableName();

            $foreignKey = $stream->getForeignKey();

            $this->schema->createTranslationsTable($table, $foreignKey);

        }
    }
}
 