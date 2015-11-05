<?php namespace Anomaly\Streams\Platform\Installer\Console\Command;

use Anomaly\Streams\Platform\Support\Collection;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Config\Repository;

/**
 * Class SetApplicationData
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Installer\Console\Command
 */
class SetApplicationData implements SelfHandling
{

    /**
     * The environment data.
     *
     * @var Collection
     */
    protected $data;

    /**
     * The console command.
     *
     * @var Command
     */
    protected $command;

    /**
     * Create a new SetApplicationData instance.
     *
     * @param Collection $data
     * @param Command    $command
     */
    function __construct(Collection $data, Command $command)
    {
        $this->data    = $data;
        $this->command = $command;
    }

    /**
     * Handle the command.
     */
    public function handle()
    {
        $this->data->put(
            'APPLICATION_NAME',
            $this->command->ask(
                'Enter the name of your application',
                env('APPLICATION_NAME', 'Default')
            )
        );

        $this->data->put(
            'APPLICATION_REFERENCE',
            $this->command->ask(
                'Enter the reference slug for your application',
                env('APPLICATION_REFERENCE', 'default')
            )
        );

        $this->data->put(
            'APPLICATION_DOMAIN',
            $this->command->ask(
                'Enter the primary domain for your application',
                env('APPLICATION_DOMAIN', 'localhost')
            )
        );
    }
}
