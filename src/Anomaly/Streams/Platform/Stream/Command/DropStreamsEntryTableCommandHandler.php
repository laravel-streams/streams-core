<?php namespace Anomaly\Streams\Platform\Stream\Command;

use Anomaly\Streams\Platform\Stream\StreamSchema;

/**
 * Class DropStreamsEntryTableCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Stream\Command
 */
class DropStreamsEntryTableCommandHandler
{

    /**
     * Handle the command.
     *
     * @param DropStreamsEntryTableCommand $command
     * @param StreamSchema                 $schema
     */
    public function handle(DropStreamsEntryTableCommand $command, StreamSchema $schema)
    {
        $stream = $command->getStream();

        $table = $stream->getEntryTableName();

        $schema->dropTable($table);

        if ($stream->isTranslatable()) {

            $table = $stream->getEntryTranslationsTableName();

            $schema->dropTable($table);
        }
    }
}
 