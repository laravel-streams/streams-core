<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

/**
 * Class CreateAddonsTable
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class CreateAddonsTable extends Migration
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

        if (!$schema->hasTable('streams_addons')) {
            $schema->create(
                'streams_addons',
                function (Blueprint $table) {
                    $table->string('namespace');
                    $table->boolean('installed')->default(0);
                    $table->boolean('enabled')->default(0);

                    $table->primary('namespace');
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

        $schema->dropIfExists('streams_addons');
    }
}
