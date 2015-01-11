<?php namespace Anomaly\Streams\Platform\Application\Command\Handler;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateFailedJobsTableHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application\Command
 */
class CreateFailedJobsTableHandler
{

    /**
     * The database object.
     *
     * @var mixed
     */
    protected $db;

    /**
     * The schema builder.
     *
     * @var Builder
     */
    protected $schema;

    /**
     * Create a new CreateFailedJobsTableHandler instance.
     */
    public function __construct()
    {
        $this->db     = app('db');
        $this->schema = app('db')->connection()->getSchemaBuilder();
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $this->createApplicationsTable();
    }

    /**
     * Create the revisions table.
     */
    protected function createApplicationsTable()
    {
        $this->schema->dropIfExists('failed_jobs');

        $this->schema->create(
            'failed_jobs',
            function (Blueprint $table) {

                $table->increments('id');
                $table->text('connection');
                $table->text('queue');
                $table->text('payload');
                $table->timestamp('failed_at');
            }
        );
    }
}
