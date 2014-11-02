<?php namespace Anomaly\Streams\Platform\Traits;

use ReflectionClass;

trait CommandableTrait
{

    /**
     * Execute a command.
     *
     * @param  string $command
     * @param  array  $input
     * @param  array  $decorators
     * @return mixed
     */
    protected function execute($command, array $input = null, $decorators = [])
    {
        $input = $input ? : app('request')->all();

        $command = $this->mapInputToCommand($command, $input);

        $bus = $this->resolveCommandBus();

        // If any decorators are passed, we'll filter through and register them
        // with the CommandBus, so that they are executed first.
        foreach ($decorators as $decorator) {

            $bus->decorate($decorator);
        }

        return $bus->execute($command);
    }

    /**
     * Fetch the command bus
     *
     * @return mixed
     */
    public function resolveCommandBus()
    {
        return app('Anomaly\Streams\Platform\Support\CommandBus');
    }

    /**
     * Map an array of input to a command's properties.
     *
     * @param  string $command
     * @param  array  $input
     * @author Taylor Otwell
     * @return mixed
     */
    protected function mapInputToCommand($command, array $input)
    {
        if (is_object($command)) {
            return $command;
        }

        $dependencies = [];

        $class = new ReflectionClass($command);

        foreach ($class->getConstructor()->getParameters() as $parameter) {
            $name = $parameter->getName();

            if (array_key_exists($name, $input)) {

                $dependencies[] = $input[$name];
            } elseif ($parameter->isDefaultValueAvailable()) {

                $dependencies[] = $parameter->getDefaultValue();
            } else {

                throw new \Exception("Unable to map variable to command: {$name}");
            }
        }

        return $class->newInstanceArgs($dependencies);
    }
}
