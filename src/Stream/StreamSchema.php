<?php

namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

/**
 * Class StreamSchema
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class StreamSchema
{

    /**
     * The schema builder.
     *
     * @var Builder
     */
    protected $schema;

    /**
     * Create a new StreamSchema instance.
     */
    public function __construct()
    {
        $this->schema = app('db')->connection()->getSchemaBuilder();
    }

    /**
     * Create a table.
     *
     * @param StreamInterface
     */
    public function createTable(StreamInterface $stream)
    {
        $table = $stream->getEntryTableName();

        $this->schema->dropIfExists($table);

        $this->schema->create(
            $table,
            function (Blueprint $table) use ($stream) {
                $table->engine = $stream->getConfig('database.engine');

                $table->increments('id');
                $table->integer('sort_order')->nullable();
                $table->datetime('created_at');
                $table->integer('created_by_id')->nullable();
                $table->datetime('updated_at')->nullable();
                $table->integer('updated_by_id')->nullable();

                if ($stream->isTrashable()) {
                    $table->datetime('deleted_at')->nullable();
                }
            }
        );
    }

    /**
     * Rename a table.
     *
     * @param StreamInterface $from
     * @param StreamInterface $to
     */
    public function renameTable(StreamInterface $from, StreamInterface $to)
    {
        if ($from->getEntryTableName() === $to->getEntryTableName()) {
            return;
        }

        $this->schema->rename($from->getEntryTableName(), $to->getEntryTableName());
    }

    /**
     * Drop a table.
     *
     * @param $table
     */
    public function dropTable($table)
    {
        $this->schema->dropIfExists($table);
    }
}
