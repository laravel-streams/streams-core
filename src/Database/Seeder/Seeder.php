<?php namespace Anomaly\Streams\Platform\Database\Seeder;

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
     * The environment this seeder
     * applies too if any.
     *
     * @var string
     */
    protected $env = null;

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
