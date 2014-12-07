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
        $parameters = $command->getParameters();

        $section = $this->factory->make($parameters);

        return $section;
    }

    protected function makeLayout($layout)
    {
        return $this->execute(
            'Anomaly\Streams\Platform\Ui\Form\Section\Command\MakeSectionCommand',
            ['parameters' => $layout]
        );
    }
}
 