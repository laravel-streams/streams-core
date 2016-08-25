<?php namespace Anomaly\Streams\Platform\Installer\Console\Command;

use Anomaly\Streams\Platform\Support\Collection;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Config\Repository;

/**
 * Class SetDatabaseData
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Installer\Console\Command
 */
class SetDatabaseData implements SelfHandling
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
     * Create a new SetDatabaseData instance.
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
            'DB_DRIVER',
            $this->command->askWithCompletion(
                'What database driver would you like to use? [mysql, postgres, sqlite, sqlsrv]',
                [
                    'mysql',
                    'postgres',
                    'sqlite',
                    'sqlsrv'
                ],
                env('DB_DRIVER', 'mysql')
            )
        );

        $this->data->put(
            'DB_HOST',
            $this->command->ask(
                'What is the hostname of your database?',
                env('DB_HOST', 'localhost')
            )
        );

        $this->data->put(
            'DB_DATABASE',
            $this->command->ask(
                'What is the name of your database?',
                env('DB_DATABASE')
            )
        );

        $this->data->put(
            'DB_USERNAME',
            $this->command->ask(
                'Enter the username for your database connection',
                env('DB_USERNAME', 'root')
            )
        );

        $this->data->put(
            'DB_PASSWORD',
            $this->command->ask(
                'Enter the password for your database connection',
                env('DB_PASSWORD')
            )
        );
    }
}
