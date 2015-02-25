<?php namespace Anomaly\Streams\Platform\Database\Seeder\Console;

use Anomaly\Streams\Platform\Database\Seeder\Command\Seed;
use Illuminate\Database\Console\SeedCommand as BaseSeedCommand;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Symfony\Component\Console\Input\InputOption;

class SeedCommand extends BaseSeedCommand
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

        $this->dispatch(new Seed(
            $this->input->getOption('addon'),
            $this->input->getOption('class'),
            $this
        ));
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return array_merge(parent::getOptions(), [
            ['addon', null, InputOption::VALUE_OPTIONAL, 'The addon to seed.']
        ]);
    }

}