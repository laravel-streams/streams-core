<?php namespace Anomaly\Streams\Platform\Ui\Form\Field\Command;

use Anomaly\Streams\Platform\Ui\Form\Field\FieldFactory;

class MakeFieldCommandHandler
{

    protected $factory;

    function __construct(FieldFactory $factory)
    {
        $this->factory = $factory;
    }

    public function handle(MakeFieldCommand $command)
    {
        return $this->factory->make($command->getParameters());
    }
}
 