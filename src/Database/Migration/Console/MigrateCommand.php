<?php namespace Anomaly\Streams\Platform\Database\Migration\Console;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\Command\GetAddon;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Foundation\Bus\DispatchesJobs;

class MigrateCommand extends \Illuminate\Database\Console\Migrations\MigrateCommand
{
    use DispatchesJobs;

    /**
     * Execute the console command.
     */
    public function fire()
    {

        /*
         * Catch the addon flag in order to
         * inject our addon layer behavior.
         */
        if ($identifier = $this->input->getOption('addon')) {

            /*
             * Make sure we have a valid addon to migrate.
             *
             * @var Addon $addon
             */
            if (!$addon = $this->dispatch(new GetAddon($identifier))) {
                throw new \Exception("$identifier addon could not be found.");
            }

            $this->migrator->setAddon($addon);

            /*
             * Just set the path since
             * Laravel bases on it anyways.
             */
            $this->input->setOption('path', $addon->getAppPath('migrations'));
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
                ['addon', null, InputOption::VALUE_OPTIONAL, 'The addon to migrate.'],
            ]
        );
    }
}
