<?php namespace Anomaly\Streams\Platform\Support;

/**
 * Class CommandBus
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Support
 */
class CommandBus
{

    /**
     * List of optional decorators.
     *
     * @var array
     */
    protected $decorators = [];

    /**
     * Add a decorator to run.
     *
     * @param  string $className
     * @return mixed
     */
    public function addDecorator($className)
    {
        $this->decorators[] = $className;

        return $this;
    }

    /**
     * Execute the command
     *
     * @param $command
     * @return mixed
     */
    public function execute($command)
    {
        $this->validateCommand($command);
        $this->executeDecorators($command);

        $handler = app('streams.transformer')->toHandler($command);

        return app()->call($handler . '@handle', compact('command'));
    }

    /**
     * Execute all registered decorators
     *
     * @param  object $command
     */
    protected function executeDecorators($command)
    {
        foreach ($this->decorators as $className) {

            app()->call($className . '@execute', compact('command'));
        }
    }

    /**
     * Try validating the command first and foremost.
     *
     * @param $command
     */
    protected function validateCommand($command)
    {
        if ($validator = app('streams.transformer')->toValidator($command)) {

            /**
             * If this fails it should set messages and then throw an exception.
             *
             * Classes utilizing the bus should catch and handle validation
             * exceptions on their own. Messages should be in the bag.
             */
            app()->call($validator . '@validate', compact('command'));
        }
    }
}
