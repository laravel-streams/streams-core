<?php namespace Anomaly\Streams\Platform\Ui\Form\Section\Command;

use Anomaly\Streams\Platform\Ui\Form\Section\SectionFactory;

class LoadFormSectionsCommandHandler
{

    protected $factory;

    function __construct(SectionFactory $factory)
    {
        $this->factory = $factory;
    }

    public function handle(LoadFormSectionsCommand $command)
    {
        $builder  = $command->getBuilder();
        $form     = $builder->getForm();
        $sections = $form->getSections();

        foreach ($builder->getSections() as $parameters) {

            $section = $this->factory->make($parameters);

            $sections->push($section);
        }
    }
}
 