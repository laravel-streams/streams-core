<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

class CreateModulesTable extends Migration
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

        if (!$schema->hasTable('addons_modules')) {
            $schema->create(
                'addons_modules',
                function (Blueprint $table) {
                    $table->increments('id');
                    $table->string('namespace');
                    $table->boolean('installed')->default(0);
                    $table->boolean('enabled')->default(0);

                    $table->unique('namespace', 'unique_modules');
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

        $schema->dropIfExists('addons_modules');
    }
}
