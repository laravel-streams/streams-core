<?php

namespace Anomaly\Streams\Platform\Stream;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Schema\Blueprint;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Field\FieldSchema;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

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
     * The stream instance.
     *
     * @var StreamInterface
     */
    protected $stream;

    /**
     * The schema builder.
     *
     * @var Builder
     */
    protected $schema;

    /**
     * Create a new StreamSchema instance.
     *
     * @param StreamInterface $stream
     */
    public function __construct(StreamInterface $stream)
    {
        $this->stream = $stream;
        $this->schema = Schema::connection(config('database.default'));
    }

    /**
     * Create the table.
     *
     * @param StreamInterface
     */
    public function create(\Closure $callback)
    {
        $this->schema->create(
            $this->stream->model ? $this->stream->model->getTable() : $this->stream->slug,
            function (Blueprint $table) use ($callback) {

                /**
                 * Add the mandatory stream fields.
                 */
                $table->increments('id');
                $table->integer('sort_order')->nullable();

                $table->datetime('created_at');
                $table->integer('created_by_id')->nullable();
                $table->datetime('updated_at')->nullable();
                $table->integer('updated_by_id')->nullable();

                if ($this->stream->trashable) {
                    $table->datetime('deleted_at')->nullable();
                }

                /**
                 * Run field schema callback.
                 */
                $schema = new FieldSchema($this->stream, $table);

                App::call($callback, compact('schema', 'table'));
            }
        );
    }

    /**
     * Drop a table.
     *
     * @param StreamInterface
     */
    public function drop()
    {
        $this->schema->dropIfExists($this->stream->model ? $this->stream->model->getTable() : $this->stream->slug);
    }
}
