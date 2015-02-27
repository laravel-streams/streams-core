<?php namespace Anomaly\Streams\Platform\Database\Migration\Console;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Database\Migration\Migrator;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class MigrateCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Console
 */
class MigrateCommand extends \Illuminate\Database\Console\Migrations\MigrateCommand
{

    use DispatchesCommands;

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
        if (!$this->input->getOption('no-addons')) {

            $addons = (new AddonCollection())->merged();

            if ($namespaces = $this->input->getOption('addon')) {

                $namespaces = explode(',', $namespaces);

                $addons = $addons->filter(
                    function (Addon $addon) use ($namespaces) {
                        return in_array($addon->getNamespace(), $namespaces);
                    }
                );
            }

            // The pretend option can be used for "simulating" the migration and grabbing
            // the SQL queries that would fire if the migration were to be run against
            // a database for real, which is helpful for double checking migrations.
            $pretend = $this->input->getOption('pretend');

            /** @var Addon $addon */
            foreach ($addons as $addon) {

                $this->migrator->setNamespace($addon->getNamespace())->run($addon->getPath('migrations'), $pretend);

                // Finally, if the "seed" option has been given, we will re-run the database
                // seed task to re-populate the database, which is convenient when adding
                // a migration and a seed at the same time, as it is only this command.
                // @todo - add this when done with addon seeding
                if ($this->input->getOption('seed')) {
                    $this->call(
                        'db:seed',
                        [
                            '--addon' => $addon->getNamespace(),
                            '--force' => true,
                        ]
                    );
                }

                // Once the migrator has run we will grab the note output and send it out to
                // the console screen, since the migrator itself functions without having
                // any instances of the OutputInterface contract passed into the class.
                foreach ($this->migrator->getNotes() as $note) {
                    $this->output->writeln($note);
                }
            }
        } else {

            $this->migrator->setNamespace('laravel');
            
            parent::fire();
        }
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
                ['no-addons', null, InputOption::VALUE_NONE, 'Don\'t run addon migrations, only laravel migrations.'],
            ]
        );
    }
}
