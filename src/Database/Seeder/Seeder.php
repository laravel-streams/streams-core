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
    protected $env;

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

        $env = $seeder->hasEnvironment();

        if ($env !== false) {

            $seeder->run();
        }

        if (isset($this->command)) {
            $this->command->getOutput()->writeln("<info>Seeded:</info> $class");
        }
    }

    /**
     * Return whether the seeder applies to
     * the current environment or not.
     *
     * @return bool|null
     */
    public function hasEnvironment()
    {
        return $this->env ? ($this->env === env('APP_ENV')) : null;
    }
}
