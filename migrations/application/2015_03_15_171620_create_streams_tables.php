<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

/**
 * Class CreateStreamsTables
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class CreateStreamsTables extends Migration
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

        if (!$schema->hasTable('streams_streams')) {
            $schema->create(
                'streams_streams',
                function (Blueprint $table) {
                    $table->increments('id');
                    $table->integer('sort_order')->nullable();
                    $table->string('namespace', 150);
                    $table->string('slug', 150);
                    $table->json('name')->nullable();
                    $table->json('description')->nullable();
                    $table->string('title_column')->default('id');
                    $table->string('order_by')->default('id');
                    $table->json('config')->nullable();
                    $table->boolean('locked')->default(0);
                    $table->boolean('hidden')->default(0);
                    $table->boolean('sortable')->default(0);
                    $table->boolean('trashable')->default(0);
                    $table->boolean('searchable')->default(0);
                    $table->boolean('versionable')->default(0);
                    $table->boolean('translatable')->default(0);

                    $table->unique(['namespace', 'slug'], 'unique_streams');
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

        $schema->dropIfExists('streams_streams');
    }
}
