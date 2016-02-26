<?php namespace Anomaly\Streams\Platform\Database\Migration\Console;

use Anomaly\Streams\Platform\Database\Migration\Migrator;
use Anomaly\Streams\Platform\Stream\Command\CleanupStreams;
use Illuminate\Database\Console\Migrations\ResetCommand as BaseResetCommand;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class ResetCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Console
 */
class ResetCommand extends BaseResetCommand
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
        // Reset a specific addon(s).
        if ($addon = $this->input->getOption('addon')) {

            $pretend = $this->input->getOption('pretend');

            $namespaces = explode(',', $addon);

            foreach ($namespaces as $namespace) {

                while (true) {

                    $count = $this->migrator->rollbackNamespace($namespace, $pretend);

                    // Once the migrator has run we will grab the note output and send it out to
                    // the console screen, since the migrator itself functions without having
                    // any instances of the OutputInterface contract passed into the class.
                    foreach ($this->migrator->getNotes() as $note) {
                        $this->output->writeln($note);
                    }

                    if ($count == 0) {
                        break;
                    }
                }
            }
        } else {

            // Reset everything.
            parent::fire();
        }

        $this->dispatch(new CleanupStreams());
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
