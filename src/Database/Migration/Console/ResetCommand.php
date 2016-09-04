<?php namespace Anomaly\Streams\Platform\Database\Migration\Console;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\Console\Input\InputOption;
use Anomaly\Streams\Platform\Database\Migration\Migrator;
use Anomaly\Streams\Platform\Database\Migration\Console\Command\ConfigureMigrator;

class ResetCommand extends \Illuminate\Database\Console\Migrations\ResetCommand
{
    use DispatchesJobs;

    /**
     * The migrator utility.
     *
     * @var Migrator
     */
    protected $migrator;

    /**
     * Execute the console command.
     *
     * @return void
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
     * Get the command options.
     *
     * @return array
     */
    public function getOptions()
    {
        return array_merge(
            parent::getOptions(),
            [
                ['addon', null, InputOption::VALUE_OPTIONAL, 'The addon to reset migrations for.'],
                ['path', null, InputOption::VALUE_OPTIONAL, 'The path to migrations to reset.'],
            ]
        );
    }
}
