<?php

namespace Anomaly\Streams\Platform\Database\Migration\Console;

use Anomaly\Streams\Platform\Database\Migration\Command\CreateAddonMigrationFolder;
use Anomaly\Streams\Platform\Database\Migration\Command\GetMigrationName;
use Anomaly\Streams\Platform\Database\Migration\MigrationCreator;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class MigrateMakeCommand.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Console
 */
class MigrateMakeCommand extends \Illuminate\Database\Console\Migrations\MigrateMakeCommand
{
    use DispatchesJobs;

    /**
     * The migration creator.
     *
     * @var MigrationCreator
     */
    protected $creator;

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'make:migration {name : The name of the migration.}
        {--addon= : The addon to create the migration file in.}
        {--fields : Create a fields type migration.}
        {--stream= : Create a stream type migration.}
        {--create= : The table to be created.}
        {--table= : The table to migrate.}
        {--path= : The location where the migration file should be created.}';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        // It's possible for the developer to specify the tables to modify in this
        // schema operation. The developer may also specify if this table needs
        // to be freshly created so we can create the appropriate migrations.
        $name = $this->input->getArgument('name');

        $create = $this->input->getOption('create');
        $table  = $this->input->getOption('table');
        $addon  = $this->input->getOption('addon');

        if (! $table && is_string($create)) {
            $table = $create;
        }

        // Now we are ready to write the migration out to disk. Once we've written
        // make sure that the migrations are registered by the class loaders.
        $this->writeMigration($name, $table, $create, $addon);
    }

    /**
     * Write the migration file to disk.
     *
     * @param string $name
     * @param string $table
     * @param bool   $create
     * @param null   $addon
     * @return string
     */
    protected function writeMigration($name, $table, $create, $addon = null)
    {
        $name = $this->dispatch(new GetMigrationName($name, $addon));

        if (! $path = $this->dispatch(new CreateAddonMigrationFolder($addon))) {
            $path = $this->getMigrationPath();
        }

        $file = pathinfo($this->creator->setCommand($this)->create($name, $path, $table, $create), PATHINFO_FILENAME);

        $this->line("<info>Created Migration:</info> $file");
    }
}
