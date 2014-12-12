<?php namespace Anomaly\Streams\Platform\Application\Command;

use Illuminate\Database\Schema\Blueprint;

class InstallApplicationTablesCommandHandler
{

    protected $db;

    protected $schema;

    function __construct()
    {
        $this->db     = app('db');
        $this->schema = app('db')->connection()->getSchemaBuilder();
    }

    public function handle(InstallApplicationTablesCommand $command)
    {
        $this->setPrefix(null);

        $this->installApplicationsTable();
        $this->installApplicationsDomainsTable();

        $this->installDefaultApplication($command->getName(), $command->getDomain(), $command->getReference());

        $this->setPrefix($command->getReference() . '_');
    }

    protected function installApplicationsTable()
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

    protected function installApplicationsDomainsTable()
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

    protected function setPrefix($prefix)
    {
        $this->schema->getConnection()->getSchemaGrammar()->setTablePrefix($prefix);
        $this->schema->getConnection()->setTablePrefix($prefix);
    }
}
 