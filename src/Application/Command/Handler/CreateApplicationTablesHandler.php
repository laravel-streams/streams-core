<?php namespace Anomaly\Streams\Platform\Application\Command\Handler;

use Anomaly\Streams\Platform\Application\Application;
use Anomaly\Streams\Platform\Application\Command\CreateApplicationTables;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

/**
 * Class CreateApplicationTablesHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Application\Command
 */
class CreateApplicationTablesHandler
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
     * The stream application.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new CreateApplicationTablesHandler instance.
     *
     * @param Application $application
     */
    public function __construct(Application $application)
    {
        $this->db     = app('db');
        $this->schema = app('db')->connection()->getSchemaBuilder();

        $this->application = $application;
    }

    /**
     * Install the application table and initial data.
     *
     * @param CreateApplicationTables $command
     */
    public function handle(CreateApplicationTables $command)
    {
        $this->setPrefix(null);

        $this->createApplicationsTable();
        $this->createApplicationsDomainsTable();

        $this->installDefaultApplication($command->getName(), $command->getDomain(), $command->getReference());

        $this->setPrefix($command->getReference() . '_');
    }

    /**
     * Create the applications table.
     */
    protected function createApplicationsTable()
    {
        $this->schema->dropIfExists('applications');

        $this->schema->create(
            'applications',
            function (Blueprint $table) {

                $table->increments('id');
                $table->string('name');
                $table->string('reference');
                $table->string('domain');
                $table->boolean('enabled');
            }
        );
    }

    /**
     * Create the applications domains table.
     */
    protected function createApplicationsDomainsTable()
    {
        $this->schema->dropIfExists('applications_domains');

        $this->schema->create(
            'applications_domains',
            function (Blueprint $table) {

                $table->increments('id');
                $table->integer('application_id');
                $table->string('domain');
                $table->string('locale');
            }
        );
    }

    /**
     * Install the default application.
     *
     * @param $name
     * @param $domain
     * @param $reference
     */
    protected function installDefaultApplication($name, $domain, $reference)
    {

        $data = [
            'name'      => $name,
            'domain'    => $domain,
            'reference' => $reference,
            'enabled'   => true,
        ];

        $this->db->table('applications')->insert($data);

        $this->application->locate();
    }

    /**
     * Set the database prefix.
     *
     * @param $prefix
     */
    protected function setPrefix($prefix)
    {
        $this->schema->getConnection()->getSchemaGrammar()->setTablePrefix($prefix);
        $this->schema->getConnection()->setTablePrefix($prefix);
    }
}
