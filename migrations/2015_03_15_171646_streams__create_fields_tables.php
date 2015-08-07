<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

/**
 * Class AnomalyModuleInstallerCreateFieldsTables
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 */
class AnomalyModuleInstallerCreateFieldsTables extends Migration
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

        if (!$schema->hasTable('streams_fields')) {
            $schema->create(
                'streams_fields',
                function (Blueprint $table) {

                    $table->increments('id');
                    $table->string('namespace');
                    $table->string('slug');
                    $table->string('type');
                    $table->text('config');
                    $table->boolean('locked')->default(0);

                    $table->unique(['namespace', 'slug']);
                }
            );
        }

        if (!$schema->hasTable('streams_fields_translations')) {
            $schema->create(
                'streams_fields_translations',
                function (Blueprint $table) {

                    $table->increments('id');
                    $table->integer('field_id');
                    $table->string('locale')->index();
                    $table->string('name')->nullable();
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

        $schema->dropIfExists('streams_fields');
        $schema->dropIfExists('streams_fields_translations');
    }
}
