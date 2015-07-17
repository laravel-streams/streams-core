<?php namespace Anomaly\Streams\Platform\Database\Migration\Console;

use Anomaly\Streams\Platform\Database\Migration\Command\CreateAddonMigrationFolder;
use Anomaly\Streams\Platform\Database\Migration\Command\GetMigrationName;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class MigrateMakeCommand
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

        if (!$table && is_string($create)) {
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

        if (!$path = $this->dispatch(new CreateAddonMigrationFolder($addon))) {
            $path = $this->getMigrationPath();
        }

        $file = pathinfo($this->creator->create($name, $path, $table, $create), PATHINFO_FILENAME);

        $this->line("<info>Created Migration:</info> $file");
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array_merge(
            parent::getOptions(),
            [
                ['addon', null, InputOption::VALUE_OPTIONAL, 'The addon where the migration will be generated.']
            ]
        );
    }
}
