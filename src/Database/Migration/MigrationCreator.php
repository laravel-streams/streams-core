<?php

namespace Anomaly\Streams\Platform\Database\Migration;

use Anomaly\Streams\Platform\Database\Migration\Command\TransformMigrationNameToClass;
use Anomaly\Streams\Platform\Database\Migration\Console\MigrateMakeCommand;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class MigrationCreator.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration
 */
class MigrationCreator extends \Illuminate\Database\Migrations\MigrationCreator
{
    use DispatchesJobs;

    /**
     * The command instance.
     *
     * @var MigrateMakeCommand
     */
    protected $command;

    /**
     * Create a new migration at the given path.
     *
     * @param  string $name
     * @param  string $path
     * @param  string $table
     * @param  bool   $create
     * @return string
     */
    public function create($name, $path, $table = null, $create = false)
    {
        $path = $this->getPath($name, $path);

        // First we will get the stub file for the migration, which serves as a type
        // of template for the migration. Once we have those we will populate the
        // various place-holders, save the file, and run the post create event.
        $stub = $this->getStub($table, $create);

        $this->files->put($path, $this->populateStub($name, $stub, $table));

        $this->firePostCreateHooks();

        return $path;
    }

    /**
     * Get the migration stub file.
     *
     * @param  string $table
     * @param  bool   $create
     * @return string
     */
    protected function getStub($table, $create)
    {
        if ($this->command->option('fields')) {
            return $this->files->get($this->getStubPath().'/fields.stub');
        }

        if ($this->command->option('stream')) {
            return $this->files->get($this->getStubPath().'/stream.stub');
        }

        if (is_null($table)) {
            return $this->files->get($this->getStubPath().'/blank.stub');
        }

        // We also have stubs for creating new tables and modifying existing tables
        // to save the developer some typing when they are creating a new tables
        // or modifying existing tables. We'll grab the appropriate stub here.
        else {
            $stub = $create ? 'create.stub' : 'update.stub';

            return $this->files->get($this->getStubPath()."/{$stub}");
        }
    }

    /**
     * Populate the place-holders in the migration stub.
     *
     * @param  string $name
     * @param  string $stub
     * @param  string $table
     * @return string
     */
    protected function populateStub($name, $stub, $table)
    {
        $class  = $this->getClassName($name);
        $stream = $this->command->option('stream');

        $stub = app('Anomaly\Streams\Platform\Support\Parser')->parse($stub, compact('class', 'table', 'stream'));

        return $stub;
    }

    /**
     * Get the path to the stubs.
     *
     * @return string
     */
    public function getStubPath()
    {
        return __DIR__.'/../../../resources/stubs/database/migrations';
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

    /**
     * Get the command.
     *
     * @return MigrateMakeCommand
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Set the command.
     *
     * @param $command
     * @return $this
     */
    public function setCommand(MigrateMakeCommand $command)
    {
        $this->command = $command;

        return $this;
    }
}
