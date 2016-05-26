<?php namespace Anomaly\Streams\Platform\Database\Seeder;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Illuminate\Database\Seeder as BaseSeeder;

/**
 * Class Seeder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Seeder
 */
class Seeder extends BaseSeeder
{

    /**
     * The field repository.
     *
     * @var FieldRepositoryInterface $fields
     */
    protected $fields;

    /**
     * The stream repository.
     *
     * @var StreamRepositoryInterface $streams
     */
    protected $streams;

    /**
     * The assignment repository.
     *
     * @var AssignmentRepositoryInterface $assignments
     */
    protected $assignments;

    /**
     * The environment this seeder
     * applies too if any.
     *
     * @var string
     */
    protected $env = null;

    /**
     * Create a new Seeder instance.
     */
    public function __construct()
    {
        $this->fields      = app(FieldRepositoryInterface::class);
        $this->streams     = app(StreamRepositoryInterface::class);
        $this->assignments = app(AssignmentRepositoryInterface::class);
    }

    /**
     * Seed the given connection from the given path.
     *
     * @param  string $class
     *
     * @return void
     */
    public function call($class)
    {
        /** @var Seeder $seeder */
        $seeder = $this->resolve($class);
        $env    = method_exists($seeder, 'isEnvironment') ? $seeder->isEnvironment() : null;

        $seeder->setCommand($this->command);

        if ($env !== false) {
            $seeder->run();
        }

        $this->command->getOutput()->writeln("<info>Seeded:</info> $class");
    }

    /**
     * Return whether the seeder applies to
     * the current environment or not.
     *
     * @return bool|null
     */
    public function isEnvironment()
    {
        return $this->env ? ($this->env === env('APP_ENV')) : null;
    }
}
