<?php

namespace Anomaly\Streams\Platform\Field;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Schema\Blueprint;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class FieldSchema
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class FieldSchema
{

    /**
     * The schema builder.
     *
     * @var Builder
     */
    protected $table;

    /**
     * The Stream instance.
     *
     * @var StreamInterface
     */
    public $stream;

    /**
     * The schema builder.
     *
     * @var Builder
     */
    protected $schema;

    /**
     * Scaffold the stream.
     *
     * @param string $model
     */
    public function __construct(StreamInterface $stream, Blueprint $table)
    {
        $this->table = $table;
        $this->stream = $stream;
        $this->schema = Schema::connection(config('database.default'));
    }

    /**
     * Add the field(s).
     *
     * @param string|array $field
     */
    public function add(FieldInterface $field)
    {

        $type = $field->type();

        // Skip if no column type.
        if (is_null($type->getColumnType())) {
            return $this;
        }

        // Skip if the column already exists. (Try update!)
        if ($this->schema->hasColumn($this->table->getTable(), $type->getColumnName())) {
            return $this;
        }

        /**
         * If the field is translatable
         * then the type becomes JSON.
         */
        if ($field->translatable) {

            $this->table->json($type->getColumnName());

            return $this;
        }

        $schema = app($type->getSchema());

        $schema->addColumn($this->table, $field);
    }
}
