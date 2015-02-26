<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\Command\GetAddonByNamespace;
use Anomaly\Streams\Platform\Database\Migration\Command\GetAddonFromMigration;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class GetAddonFromMigrationHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Command\Handler
 */
class GetAddonFromMigrationHandler
{

    use DispatchesCommands;

    /**
     * Handle the command.
     *
     * @param GetAddonFromMigration $command
     * @return Addon|null
     */
    public function handle(GetAddonFromMigration $command)
    {
        $matcher = '[a-zA-Z\\_\\-]+';

        $reflection = new \ReflectionClass($command->getMigration());

        $fileName = implode('_', array_slice(explode('_', basename($reflection->getFileName())), 4));

        preg_match("/^({$matcher}\\.{$matcher}\\.{$matcher})\\_\\_/", $fileName, $matches);

        return $this->dispatch(
            new GetAddonByNamespace(
                $namespace = isset($matches[1]) ? $matches[1] : null
            )
        );
    }
}
