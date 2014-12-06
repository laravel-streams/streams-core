<?php namespace Anomaly\Streams\Platform\Ui\Form\Section\Command;

use Anomaly\Streams\Platform\Ui\Form\Field\FieldCollection;
use Anomaly\Streams\Platform\Ui\Form\Section\SectionFactory;

class MakeSectionCommandHandler
{

    protected $factory;

    function __construct(SectionFactory $factory)
    {
        $this->factory = $factory;
    }

    public function handle(MakeSectionCommand $command)
    {
        $parameters = $command->getParameters();

        if (isset($parameters['fields']) and !$parameters['fields'] instanceof FieldCollection) {

            $parameters['fields'] = $this->buildFieldCollection($parameters['fields']);
        }

        return $this->factory->make($parameters);
    }

    protected function buildFieldCollection(array $fields)
    {
        return new FieldCollection();
    }
}
 