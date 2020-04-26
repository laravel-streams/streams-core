<?php

namespace Anomaly\Streams\Platform\Stream;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Schema\Blueprint;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

/**
 * Class StreamMigrator
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class StreamMigrator
{

    /**
     * The model instance.
     *
     * @var EntryModel
     */
    protected static $model;

    /**
     * The Stream instance.
     *
     * @var StreamInterface
     */
    protected static $stream;

    /**
     * The scahema builder.
     *
     * @var Builder
     */
    protected static $schema;

    /**
     * Scaffold the stream.
     *
     * @param string $model
     */
    public static function create(string $model)
    {
        self::$model = app($model);
        self::$stream = self::$model->stream();
        self::$schema = Schema::connection(config('database.default'));

        dd(new StreamSchema(self::$model, self::$schema));
        self::createTable();

        foreach (self::$stream->fields as $field) {
            FieldSchema::addField($field);
        }
    }

    /**
     * Teardown the stream.
     *
     * @param string $model
     */
    public static function drop(string $model)
    {
        self::$model = app($model);
        self::$stream = self::$model->stream();
        self::$schema = Schema::connection(config('database.default'));

        self::dropTable();
    }


    /**
     * Create a table.
     *
     * @param StreamInterface
     */
    public static function createTable()
    {
        self::$schema->create(
            self::$model->getTable(),
            function (Blueprint $table) {

                $table->increments('id');
                $table->integer('sort_order')->nullable();

                $table->datetime('created_at');
                $table->integer('created_by_id')->nullable();
                $table->datetime('updated_at')->nullable();
                $table->integer('updated_by_id')->nullable();

                if (self::$stream->trashable) {
                    $table->datetime('deleted_at')->nullable();
                }
            }
        );
    }

    /**
     * Drop a table.
     *
     * @param StreamInterface
     */
    public static function dropTable()
    {
        self::$schema->dropIfExists(self::$model->getTable());
    }

    /**
     * Add the field column.
     *
     * @param FieldInterface $field
     */
    public function addField(FieldInterface $field)
    {
        // Skip if no column type.
        if (!$type = $field->type()->getColumnType()) {
            return;
        }

        // Skip if the column already exists.
        if (self::$schema->hasColumn($table->getTable(), self::$fieldType->getColumnName())) {
            return;
        }

        /**
         * If the field is translatable
         * then the type becomes JSON.
         */
        if ($assignment->isTranslatable()) {
            $type = 'json';
        }

        /**
         * Add the column to the table.
         *
         * @var Blueprint|Fluent $column
         */
        $column = call_user_func_array(
            [$table, $type],
            array_filter(
                [
                    self::$fieldType->getColumnName(),
                    self::$fieldType->getColumnLength(),
                ]
            )
        );

        $column->nullable(!$assignment->isTranslatable() ? !$assignment->isRequired() : true);

        if (!str_contains(self::$fieldType->getColumnType(), ['text', 'blob'])) {
            $column->default(array_get(self::$fieldType->getConfig(), 'default_value'));
        }
    }
}
