<?php namespace Anomaly\Streams\Platform\Application\Command;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

/**
 * Class CreateApplicationTablesCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Application\Command
 */
class CreateApplicationTablesCommandHandler
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
     * Create a new CreateApplicationTablesCommandHandler instance.
     */
    public function __construct()
    {
        $this->db     = app('db');
        $this->schema = app('db')->connection()->getSchemaBuilder();
    }

    /**
     * Install the application table and initial data.
     *
     * @param CreateApplicationTablesCommand $command
     */
    public function handle(CreateApplicationTablesCommand $command)
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

        app('streams.application')->locate();
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
