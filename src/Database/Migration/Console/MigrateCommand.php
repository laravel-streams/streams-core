<?php namespace Anomaly\Streams\Platform\Database\Migration\Console;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\Console\Input\InputOption;
use Anomaly\Streams\Platform\Database\Migration\Console\Command\ConfigureMigrator;

class MigrateCommand extends \Illuminate\Database\Console\Migrations\MigrateCommand
{
    use DispatchesJobs;

    /**
     * Execute the console command.
     */
    public function fire()
    {
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
            ]
        );
    }
}
