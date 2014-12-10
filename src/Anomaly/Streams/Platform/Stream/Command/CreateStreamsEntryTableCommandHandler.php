<?php namespace Anomaly\Streams\Platform\Stream\Command;

use Anomaly\Streams\Platform\Stream\StreamSchema;

/**
 * Class CreateStreamsEntryTableCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream\Command
 */
class CreateStreamsEntryTableCommandHandler
{

    protected $schema;

    function __construct(StreamSchema $schema)
    {
        $this->schema = $schema;
    }

    /**
     * Create a new CreateStreamsEntryTableCommandHandler instance.
     *
     * @param CreateStreamsEntryTableCommand $command
     */
    public function handle(CreateStreamsEntryTableCommand $command)
    {
        $stream = $command->getStream();

        $table = $stream->getEntryTableName();

        $this->schema->createTable($table);

        if ($stream->isTranslatable()) {

            $table = $stream->getEntryTranslationsTableName();

            $foreignKey = $stream->getForeignKey();

            $this->schema->createTranslationsTable($table, $foreignKey);
        }
    }
}
 