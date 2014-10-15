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
            $instance = $this->app->make($className);

            if (!$instance instanceof CommandBus) {
                $message = 'The class to decorate must be an implementation of Streams\Platform\Contract\CommandBus';

                throw new \Exception($message);
            }

            $instance->execute($command);
        }
    }
}
