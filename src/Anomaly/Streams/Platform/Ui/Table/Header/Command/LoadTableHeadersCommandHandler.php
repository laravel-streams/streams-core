<?php namespace Anomaly\Streams\Platform\Ui\Table\Header\Command;

use Anomaly\Streams\Platform\Ui\Table\Header\HeaderFactory;

/**
 * Class LoadTableHeadersCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Header\Command
 */
class LoadTableHeadersCommandHandler
{

    /**
     * The factory object.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Header\HeaderFactory
     */
    protected $factory;

    /**
     * Create a new LoadTableHeadersCommandHandler instance.
     *
     * @param HeaderFactory $factory
     */
    public function __construct(HeaderFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Handle the command.
     *
     * @param LoadTableHeadersCommand $command
     */
    public function handle(LoadTableHeadersCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();
        $headers = $table->getHeaders();
        $stream  = $table->getStream();

        foreach ($builder->getColumns() as $parameters) {
            $header = $this->factory->make(array_get($parameters, 'header', []));

            if ($stream) {
                $header->setStream($stream);
            }

            $headers->push($header);
        }
    }
}
