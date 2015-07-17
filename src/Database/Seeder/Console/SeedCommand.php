<?php namespace Anomaly\Streams\Platform\Database\Seeder\Console;

use Anomaly\Streams\Platform\Database\Seeder\Command\Seed;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class SeedCommand
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Seeder\Console
 */
class SeedCommand extends \Illuminate\Database\Console\Seeds\SeedCommand
{

    use DispatchesCommands;

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

        $this->resolver->setDefaultConnection($this->getDatabase());

        $this->dispatch(
            new Seed(
                $this->input->getOption('addon'),
                $this->input->getOption('class'),
                $this
            )
        );
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
                ['addon', null, InputOption::VALUE_OPTIONAL, 'The addon to seed.']
            ]
        );
    }
}
