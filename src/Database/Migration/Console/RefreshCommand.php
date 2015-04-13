<?php namespace Anomaly\Streams\Platform\Database\Migration\Console;

use Anomaly\Streams\Platform\Database\Migration\Migrator;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class RefreshCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Console
 */
class RefreshCommand extends \Illuminate\Database\Console\Migrations\RefreshCommand
{

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
        if (!$this->confirmToProceed()) {
            return;
        }

        $addon    = $this->input->getOption('addon');
        $force    = $this->input->getOption('force');
        $database = $this->input->getOption('database');
        $noAddons = $this->input->getOption('no-addons');

        $this->call(
            'migrate:reset',
            array(
                '--database'  => $database,
                '--force'     => $force,
                '--addon'     => $addon,
                '--no-addons' => $noAddons
            )
        );

        // The refresh command is essentially just a brief aggregate of a few other of
        // the migration commands and just provides a convenient wrapper to execute
        // them in succession. We'll also see if we need to re-seed the database.
        $this->call(
            'migrate',
            array(
                '--database'  => $database,
                '--force'     => $force,
                '--addon'     => $addon,
                '--no-addons' => $noAddons
            )
        );

        if ($this->input->getOption('seed')) {
            $this->call(
                'db:seed',
                array(
                    '--database' => $database,
                    '--force'    => $force,
                    '--addon'    => $addon
                )
            );
        }
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
                ['addon', null, InputOption::VALUE_OPTIONAL, 'The addon to reset migrations.'],
                ['no-addons', null, InputOption::VALUE_NONE, 'Don\'t run addon migrations, only laravel migrations.'],
            ]
        );
    }
}
