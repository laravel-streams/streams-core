<?php namespace Anomaly\Streams\Platform\Database\Migration;

use Anomaly\Streams\Platform\Database\Migration\Command\TransformMigrationNameToClass;
use Illuminate\Database\Migrations\MigrationCreator as BaseMigrationCreator;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class MigrationCreator
 *
 * @package Anomaly\Streams\Platform\Database\Migration
 */
class MigrationCreator extends BaseMigrationCreator
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