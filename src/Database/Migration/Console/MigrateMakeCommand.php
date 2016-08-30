<?php namespace Anomaly\Streams\Platform\Database\Migration\Console;

use Anomaly\Streams\Platform\Database\Migration\MigrationCreator;
use Anomaly\Streams\Platform\Database\Migration\Console\Command\ConfigureCreator;
use Illuminate\Foundation\Bus\DispatchesJobs;

class MigrateMakeCommand extends \Illuminate\Database\Console\Migrations\MigrateMakeCommand
{
    use DispatchesJobs;

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'make:migration {name : The name of the migration.}
        {--table= : The table to migrate.}
        {--create= : The table to be created.}
        {--fields= : Create a fields migration.}
        {--addon= : The addon to create a migration for.}
        {--stream= : The stream to create a migration for.}
        {--path= : The location where the migration file should be created.}';

    /**
     * The migration creator.
     *
     * @var MigrationCreator
     */
    protected $creator;

    /**
     * Execute the console command.
     */
    public function fire()
    {
        $this->dispatch(
            new ConfigureCreator(
                $this,
                $this->input,
                $this->creator
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
                ['addon', null, InputOption::VALUE_OPTIONAL, 'The addon to create a migration for.'],
                ['stream', null, InputOption::VALUE_NONE, 'The stream to create a migration for.'],
                ['fields', null, InputOption::VALUE_NONE, 'Create a fields migration.'],
            ]
        );
    }
}
