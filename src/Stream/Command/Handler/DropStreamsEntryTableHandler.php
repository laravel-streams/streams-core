<?php

namespace Anomaly\Streams\Platform\Stream\Command\Handler;

use Anomaly\Streams\Platform\Stream\Command\DropStreamsEntryTable;
use Anomaly\Streams\Platform\Stream\StreamSchema;

/**
 * Class DropStreamsEntryTableHandler.
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Stream\Command
 */
class DropStreamsEntryTableHandler
{
    /**
     * The stream schema.
     *
     * @var StreamSchema
     */
    protected $schema;

    /**
     * Create a new DropStreamsEntryTableHandler instance.
     *
     * @param StreamSchema $schema
     */
    public function __construct(StreamSchema $schema)
    {
        $this->schema = $schema;
    }

    /**
     * Handle the command.
     *
     * @param DropStreamsEntryTable $command
     */
    public function handle(DropStreamsEntryTable $command)
    {
        $stream = $command->getStream();

        $table = $stream->getEntryTableName();

        $this->schema->dropTable($table);

        if ($stream->isTranslatable()) {
            $table = $stream->getEntryTranslationsTableName();

            $this->schema->dropTable($table);
        }
    }
}
