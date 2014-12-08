<?php namespace Anomaly\Streams\Platform\Ui\Form\Section\Command;

class StandardizeSectionInputCommandHandler
{

    public function handle(StandardizeSectionInputCommand $command)
    {
        $builder = $command->getBuilder();

        $sections = [];

        foreach ($builder->getSections() as $key => $section) {

            if (isset($section['fields'])) {

                $section['section'] = 'fields';
            }

            $sections[] = $section;
        }

        $builder->setSections($sections);
    }
}
 