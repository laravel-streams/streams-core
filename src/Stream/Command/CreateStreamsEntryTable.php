<?php namespace Anomaly\Streams\Platform\Stream\Command;

use Anomaly\Streams\Platform\Stream\StreamSchema;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

class CreateStreamsEntryTable
{

    /**
     * The stream interface.
     *
     * @var StreamInterface
     */
    protected $stream;

    /**
     * Create a new CreateStreamsEntryTable instance.
     *
     * @param StreamInterface $stream
     */
    public function __construct(StreamInterface $stream)
    {
        $this->stream = $stream;
    }

    /**
     * Handle the command.
     *
     * @param StreamSchema $schema
     */
    public function handle(StreamSchema $schema)
    {
        $schema->createTable($this->stream);

        if ($this->stream->isTranslatable()) {
            $table = $this->stream->getEntryTranslationsTableName();

            $schema->createTranslationsTable($table);
        }
    }
}
