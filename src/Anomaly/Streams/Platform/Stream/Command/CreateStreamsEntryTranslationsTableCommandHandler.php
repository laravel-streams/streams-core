<?php namespace Anomaly\Streams\Platform\Stream\Command;

use Anomaly\Streams\Platform\Stream\StreamSchema;

class CreateStreamsEntryTranslationsTableCommandHandler
{
    protected $schema;

    function __construct(StreamSchema $schema)
    {
        $this->schema = $schema;
    }

    public function handle(CreateStreamsEntryTranslationsTableCommand $command)
    {
        $this->schema->createTranslationsTable($command->getTable());
    }
}
 