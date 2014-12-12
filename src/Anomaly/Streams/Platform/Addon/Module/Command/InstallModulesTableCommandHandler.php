<?php namespace Anomaly\Streams\Platform\Addon\Module\Command;

use Illuminate\Database\Schema\Blueprint;

class InstallModulesTableCommandHandler
{
    protected $db;

    protected $schema;

    function __construct()
    {
        $this->db     = app('db');
        $this->schema = app('db')->connection()->getSchemaBuilder();
    }

    public function handle()
    {
        $this->installModulesTable();
    }

    protected function installModulesTable()
    {
        $this->schema->dropIfExists('addons_modules');

        $this->schema->create(
            'addons_modules',
            function (Blueprint $table) {

                $table->increments('id');
                $table->string('slug');
                $table->boolean('installed')->default(0);
                $table->boolean('enabled')->default(0);

            }
        );
    }
}
