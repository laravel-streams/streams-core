<?php namespace Anomaly\Streams\Platform\Database\Migration\Console;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\Console\Input\InputOption;
use Anomaly\Streams\Platform\Database\Migration\Console\Command\MigrateStreams;
use Anomaly\Streams\Platform\Database\Migration\Console\Command\MigrateAllAddons;
use Anomaly\Streams\Platform\Database\Migration\Console\Command\ConfigureMigrator;

class MigrateCommand extends \Illuminate\Database\Console\Migrations\MigrateCommand
{
    use DispatchesJobs;

    /**
     * Execute the console command.
     */
    public function fire()
    {
        if ($this->input->getOption('streams')) {
            return $this->dispatch(new MigrateStreams($this));
        }

        if ($this->input->getOption('all-addons')) {
            return $this->dispatch(new MigrateAllAddons($this));
        }

        $this->dispatch(
            new ConfigureMigrator(
                $this,
                $this->input,
                $this->migrator
            )
        );

        parent::fire();
    }

    /**
     * Get the options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array_merge(
            parent::getOptions(),
            [
                ['addon', null, InputOption::VALUE_OPTIONAL, 'The addon to migrate.'],
                ['streams', null, InputOption::VALUE_NONE, 'Flag all streams core/application for migration.'],
                ['all-addons', null, InputOption::VALUE_NONE, 'Flag all addons for migration.'],
            ]
        );
    }
}
