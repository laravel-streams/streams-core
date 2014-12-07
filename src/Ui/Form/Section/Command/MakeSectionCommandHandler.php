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

        if (isset($parameters['layout'])) {

            $parameters['layout'] = $this->makeLayout($parameters['layout']);
        }

        return $this->factory->make($parameters);
    }

    protected function makeLayout($layout)
    {
        return $this->execute(
            'Anomaly\Streams\Platform\Ui\Form\Section\Command\MakeSectionCommand',
            ['parameters' => $layout]
        );
    }
}
 