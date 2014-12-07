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

    /**
     * Create a new CreateStreamsEntryTableCommandHandler instance.
     *
     * @param CreateStreamsEntryTableCommand $command
     * @param StreamSchema                   $schema
     */
    public function handle(CreateStreamsEntryTableCommand $command, StreamSchema $schema)
    {
        $stream = $command->getStream();

        $table = $stream->getEntryTableName();

        $schema->createTable($table);

        if ($stream->isTranslatable()) {

            $table = $stream->getEntryTranslationsTableName();

            $foreignKey = $stream->getForeignKey();

            $schema->createTranslationsTable($table, $foreignKey);
        }
    }
}
 