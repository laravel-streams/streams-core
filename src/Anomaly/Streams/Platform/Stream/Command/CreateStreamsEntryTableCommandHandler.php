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
        $this->schema->createTable($command->getTable());
    }
}
 