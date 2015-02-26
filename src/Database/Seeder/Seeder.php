<?php namespace Anomaly\Streams\Platform\Database\Seeder;

use Illuminate\Database\Seeder as BaseSeeder;

class Seeder extends BaseSeeder
{

    /**
     * @var
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
     * @return bool|null
     */
    public function hasEnvironment()
    {
        return $this->env ? ($this->env === env('APP_ENV')) : null;
    }

}