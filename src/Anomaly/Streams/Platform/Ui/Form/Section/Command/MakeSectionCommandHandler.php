<?php namespace Anomaly\Streams\Platform\Ui\Form\Section\Command;

use Anomaly\Streams\Platform\Ui\Form\Section\SectionFactory;
use Laracasts\Commander\CommanderTrait;

class MakeSectionCommandHandler
{

    use CommanderTrait;

    protected $factory;

    function __construct(SectionFactory $factory)
    {
        $this->factory = $factory;
    }

    public function handle(MakeSectionCommand $command)
    {
        return $this->factory->make($command->getParameters());
    }
}
 