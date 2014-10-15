<?php namespace Streams\Platform\Support;

use Illuminate\Foundation\Application;

class CommandBus
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Transformer
     */
    protected $transformer;

    /**
     * List of optional decorators for command bus.
     *
     * @var array
     */
    protected $decorators = [];

    /**
     * @param Application $app
     * @param Transformer $transformer
     */
    function __construct(Application $app, Transformer $transformer)
    {
        $this->app         = $app;
        $this->transformer = $transformer;
    }

    /**
     * Decorate the command bus with any executable actions.
     *
     * @param  string $className
     * @return mixed
     */
    public function decorate($className)
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
        $this->validateCommand($command); // First!
        $this->executeDecorators($command);

        $handler = $this->transformer->toHandler($command);

        return $this->app->make($handler)->handle($command);
    }

    /**
     * Execute all registered decorators
     *
     * @param  object $command
     * @return null
     */
    protected function executeDecorators($command)
    {
        foreach ($this->decorators as $className) {
            $this->app->make($className)->execute($command);
        }
    }

    /**
     * Try validating the command first and foremost.
     *
     * @param $command
     */
    protected function validateCommand($command)
    {
        try {

            // If the validator doesn't exist this bombs - so we try..
            $validator = $this->transformer->toValidator($command);

            /**
             * If this fails it should set messages and then throw an exception.
             *
             * Classes utilizing the bus should catch and handle validation
             * exceptions on their own. Messages should be in the bag.
             */
            $this->app->make($validator)->validate($command);

        } catch (\Exception $e) {

            // If the validator doesn't exist just move along.

        }
    }
}
