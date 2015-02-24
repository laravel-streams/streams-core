<?php namespace Anomaly\Streams\Platform\Database\Migration\Console;

use Anomaly\Streams\Platform\Database\Migration\Migrator;
use Illuminate\Database\Console\Migrations\ResetCommand as BaseResetCommand;
use Symfony\Component\Console\Input\InputOption;

class ResetCommand extends BaseResetCommand
{

    /**
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
        // Reset a specific addon
        if ($namespaces = $this->input->getOption('addon')) {

            $pretend = $this->input->getOption('pretend');

            $namespaces = explode(',', $namespaces);

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

            // Reset everything
            parent::fire();
        }
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return array_merge(parent::getOptions(), [
            ['addon', null, InputOption::VALUE_OPTIONAL, 'The addon to reset migrations.'],
            ['no-addons', null, InputOption::VALUE_NONE, 'Don\'t run addon migrations, only laravel migrations.'],
        ]);
    }

}