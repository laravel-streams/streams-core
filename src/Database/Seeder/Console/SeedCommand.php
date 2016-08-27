<?php namespace Anomaly\Streams\Platform\Database\Seeder\Console;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\Console\Input\InputOption;
use Anomaly\Streams\Platform\Database\Seeder\Command\Seed;
use Anomaly\Streams\Platform\Database\Seeder\Console\Command\SetAddonSeederClass;

class SeedCommand extends \Illuminate\Database\Console\Seeds\SeedCommand
{
    use DispatchesJobs;

    /**
     * Execute the console command.
     */
    public function fire()
    {
        $this->dispatch(
            new SetAddonSeederClass(
                $this,
                $this->input
            )
        );

        $path = $this->input->getOption('class');

        if ($path && !class_exists($path)) {
            return $this->info('Nothing to seed.');
        }

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
                ['addon', null, InputOption::VALUE_OPTIONAL, 'The addon to seed.'],
            ]
        );
    }
}
