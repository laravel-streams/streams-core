<?php namespace Anomaly\Streams\Platform\Ui\Table\Header\Command;

use Anomaly\Streams\Platform\Ui\Table\Header\HeaderFactory;

class LoadTableHeadersCommandHandler
{
    protected $factory;

    public function __construct(HeaderFactory $factory)
    {
        $this->factory = $factory;
    }

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
