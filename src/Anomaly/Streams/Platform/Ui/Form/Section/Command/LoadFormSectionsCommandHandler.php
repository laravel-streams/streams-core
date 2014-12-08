<?php namespace Anomaly\Streams\Platform\Ui\Form\Section\Command;

class LoadFormSectionsCommandHandler
{

    public function handle(LoadFormSectionsCommand $command)
    {
        $builder  = $command->getBuilder();
        $form     = $builder->getForm();
        $sections = $form->getSections();

        foreach ($builder->getSections() as $parameters) {

            $section = $this->execute(
                'Anomaly\Streams\Platform\Ui\Form\Section\Command\MakeSectionCommand',
                compact('parameters')
            );

            $sections->push($section);
        }
    }
}
 