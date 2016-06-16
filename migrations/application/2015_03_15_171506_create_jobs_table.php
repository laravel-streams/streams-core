<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateJobsTable
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 */
class CreateJobsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'jobs',
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedInteger('created_at');
                $table->unsignedInteger('available_at');
                $table->unsignedInteger('reserved_at')->nullable();
                $table->string('queue');
                $table->longText('payload');
                $table->tinyInteger('attempts')->unsigned();
                $table->tinyInteger('reserved')->unsigned();
                $table->index(['queue', 'reserved', 'reserved_at']);
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('jobs');
    }
}
