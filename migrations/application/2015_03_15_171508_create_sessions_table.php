<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateSessionsTable
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 */
class CreateSessionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'sessions',
            function (Blueprint $table) {
                $table->string('id')->unique();
                $table->text('payload');
                $table->integer('last_activity');
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
        Schema::drop('sessions');
    }
}
