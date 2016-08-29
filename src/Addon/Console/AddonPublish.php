<?php namespace Anomaly\Streams\Platform\Addon\Console;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\Console\Command\PublishConfig;
use Anomaly\Streams\Platform\Addon\Console\Command\PublishTranslations;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Console\Command;

class AddonPublish extends Command
{
    use DispatchesJobs;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'addon:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish an the configuration and translations for an addon.';

    /**
     * Execute the console command.
     */
    public function fire(AddonCollection $addons)
    {
        if (!$this->argument('addon')) {
            foreach ($this->addons as $addon) {
                $this->call(
                    'addon:publish',
                    [
                        'addon' => $addon->getNamespace(),
                    ]
                );
            }
        }

        $addon = $addons->get($this->argument('addon'));

        $this->dispatch(new PublishConfig($addon));
        $this->dispatch(new PublishTranslations($addon));
    }

    /**
     * Get the command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['addon', InputArgument::OPTIONAL, 'The addon to publish. Omit to publish all addons.'],
        ];
    }

    /**
     * Get the command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            // ['shared', null, InputOption::VALUE_NONE, 'Indicates if the addon should be created in shared addons.'],
            // ['migration', null, InputOption::VALUE_NONE, 'Indicates if a fields migration should be created.'],
        ];
    }
}
