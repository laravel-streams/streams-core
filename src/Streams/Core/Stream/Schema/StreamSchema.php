<?php namespace Streams\Platform\Stream\Schema;

use Streams\Platform\Stream\Model\StreamModel;

class StreamSchema
{
    /**
     * The model object.
     *
     * @var \Streams\Model\StreamModel
     */
    protected $model;

    /**
     * Create a new StreamSchema instance.
     *
     * @param StreamModel $model
     */
    public function __construct(StreamModel $model)
    {
        $this->model = $model;
    }

    /**
     * Create the table with system columns.
     */
    public function create()
    {
        if (!\Schema::hasTable($this->model->entryTable())) {
            \Schema::create(
                $this->model->entryTable(),
                function ($table) {
                    $table->increments('id');
                    $table->integer('sort_order')->nullable();
                    $table->datetime('created_at');
                    $table->integer('created_by')->nullable();
                    $table->datetime('updated_at')->nullable();
                    $table->integer('updated_by')->nullable();
                }
            );
        }

        if ($this->model->is_translatable and !\Schema::hasTable($this->model->translatableTable())) {
            \Schema::create(
                $this->model->translatableTable(),
                function ($table) {
                    $table->increments('id');
                    $table->integer('sort_order')->nullable();
                    $table->datetime('created_at');
                    $table->integer('created_by')->nullable();
                    $table->datetime('updated_at')->nullable();
                    $table->integer('updated_by')->nullable();
                }
            );
        }
    }

    /**
     * Update the table.
     */
    public function update()
    {
        // Rename the table if needed.
        $from = $this->model->getTable();
        $to   = $this->model->prefix . $this->model->slug;

        if (!empty($to) and \Schema::hasTable($from) and $from != $to) {
            \Schema::rename($from, $to);
        }
    }

    /**
     * Delete the tables.
     */
    public function delete()
    {
        \Schema::dropIfExists($this->model->entryTable());
        \Schema::dropIfExists($this->model->translatableTable());
    }
}
