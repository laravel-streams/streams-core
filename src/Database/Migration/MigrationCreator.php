<?php namespace Anomaly\Streams\Platform\Database\Migration;

use Anomaly\Streams\Platform\Support\Parser;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Class MigrationCreator
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class MigrationCreator extends \Illuminate\Database\Migrations\MigrationCreator
{

    /**
     * The command input.
     *
     * @var InputInterface
     */
    protected $input = null;

    public function create($name, $path, $table = null, $create = false)
    {
        $this->ensureMigrationDoesntAlreadyExist($name, $path);

        // First we will get the stub file for the migration, which serves as a type
        // of template for the migration. Once we have those we will populate the
        // various place-holders, save the file, and run the post create event.
        $stub = $this->getStub($table, $create);

        $path = $this->getPath($name, $path);

        $this->files->ensureDirectoryExists(dirname($path));

        $this->files->put(
            $path, $this->populateStreamsStub($name, $stub, $table)
        );

        // Next, we will fire any hooks that are supposed to fire after a migration is
        // created. Once that is done we'll be ready to return the full path to the
        // migration file so it can be used however it's needed by the developer.
        $this->firePostCreateHooks($table, $path);

        return $path;
    }

    /**
     * Get the migration stub file.
     *
     * @param  string $table
     * @param  bool $create
     * @return string
     */
    protected function getStub($table, $create)
    {
        if ($this->input && $this->input->getOption('fields')) {
            return $this->files->get($this->getStubPath() . '/fields.stub');
        }

        if ($this->input && $this->input->getOption('stream')) {
            return $this->files->get($this->getStubPath() . '/stream.stub');
        }

        if (is_null($table)) {
            return $this->files->get($this->getStubPath() . '/blank.stub');
        }

        return parent::getStub($table, $create);
    }

    /**
     * Populate the place-holders in the migration stub.
     *
     * @param  string $name
     * @param  string $stub
     * @param  string $table
     * @return string
     * @todo This needs cleaned up
     */
    protected function populateStreamsStub($name, $stub, $table)
    {
        $class = $this->getClassName($name);

        if ($this->input) {

            $stream = $this->input->getOption('stream');

            return app(Parser::class)->parse($stub, compact('class', 'table', 'stream'));
        }

        $stub = str_replace(
            ['DummyClass', '{{ class }}', '{{class}}'],
            $this->getClassName($name), $stub
        );

        // Here we will replace the table place-holders with the table specified by
        // the developer, which is useful for quickly creating a tables creation
        // or update migration from the console instead of typing it manually.
        if (! is_null($table)) {
            $stub = str_replace(
                ['DummyTable', '{{ table }}', '{{table}}'],
                $table, $stub
            );
        }

        return $stub;
    }

    /**
     * Get the class name of a migration name.
     *
     * @param  string $name
     * @return string
     */
    protected function getClassName($name)
    {
        return studly_case(str_replace('.', '_', $name));
    }

    /**
     * Get the path to the stubs.
     *
     * @return string
     */
    public function getStubPath()
    {
        return __DIR__ . '/../../../resources/stubs/database/migrations';
    }

    /**
     * Set the command input.
     *
     * @param  InputInterface $input
     * @return $this
     */
    public function setInput(InputInterface $input)
    {
        $this->input = $input;

        return $this;
    }
}
