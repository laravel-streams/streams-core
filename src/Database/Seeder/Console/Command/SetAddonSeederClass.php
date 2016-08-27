<?php namespace Anomaly\Streams\Platform\Database\Seeder\Console\Command;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\Streams\Platform\Addon\Command\GetAddon;
use Symfony\Component\Console\Input\InputInterface;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Console\Command;

class SetAddonSeederClass
{
    use DispatchesJobs;

    /**
     * The input service.
     *
     * @var InputInterface
     */
    protected $input;

    /**
     * The console command.
     *
     * @var Command
     */
    protected $command;

    /**
     * Create a new SetAddonPath instance.
     *
     * @param ResetCommand   $command
     * @param InputInterface $input
     */
    public function __construct(Command $command, InputInterface $input)
    {
        $this->input   = $input;
        $this->command = $command;
    }

    /**
     * Handle the command.
     *
     * @param AddonCollection $addons
     */
    public function handle(AddonCollection $addons)
    {
        if (!$addon = $this->input->getOption('addon')) {
            return;
        }

        if (!$addon = $this->dispatch(new GetAddon($addon))) {
            throw new \Exception("$identifier addon could not be found.");
        }

        $this->input->setOption('class', get_class($addon) . 'Seeder');
    }
}
