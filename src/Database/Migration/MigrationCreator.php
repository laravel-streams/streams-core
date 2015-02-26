<?php namespace Anomaly\Streams\Platform\Database\Migration;

use Anomaly\Streams\Platform\Database\Migration\Command\TransformMigrationNameToClass;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class MigrationCreator
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration
 */
class MigrationCreator extends \Illuminate\Database\Migrations\MigrationCreator
{

    use DispatchesCommands;

    /**
     * Get the path to the stubs.
     *
     * @return string
     */
    public function getStubPath()
    {
        return __DIR__ . '/../../../resources/assets/migration/stubs';
    }

    /**
     * Get the class name of a migration name.
     *
     * @param  string $name
     *
     * @return string
     */
    protected function getClassName($name)
    {
        return $this->dispatch(new TransformMigrationNameToClass($name));
    }
}
