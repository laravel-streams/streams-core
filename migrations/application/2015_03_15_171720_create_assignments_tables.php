<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

/**
 * Class CreateAssignmentsTables
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class CreateAssignmentsTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* @var Builder $schema */
        $schema = app('db')->connection()->getSchemaBuilder();

        if (!$schema->hasTable('streams_assignments')) {
            $schema->create(
                'streams_assignments',
                function (Blueprint $table) {
                    $table->increments('id');
                    $table->integer('sort_order');
                    $table->integer('stream_id');
                    $table->integer('field_id');
                    $table->boolean('unique')->default(0);
                    $table->boolean('required')->default(0);
                    $table->boolean('translatable')->default(0);

                    $table->json('label')->nullable();
                    $table->json('warning')->nullable();
                    $table->json('placeholder')->nullable();
                    $table->json('instructions')->nullable();
                    $table->json('config')->nullable();

                    $table->unique(['stream_id', 'field_id'], 'unique_assignments');
                }
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /* @var Builder $schema */
        $schema = app('db')->connection()->getSchemaBuilder();

        $schema->dropIfExists('streams_assignments');
    }
}
