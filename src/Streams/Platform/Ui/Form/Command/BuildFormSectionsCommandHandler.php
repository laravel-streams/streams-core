<?php namespace Streams\Platform\Ui\Form\Command;

class BuildFormSectionsCommandHandler
{
    public function handle(BuildFormSectionsCommand $command)
    {
        $ui = $command->getUi();

        $sections = [];

        foreach ($ui->getSections() as $section) {

            $title  = $this->makeTitle($section, $ui);
            $fields = $this->makeFields($section, $ui);

            $sections[] = compact('title', 'fields');

        }

        return $sections;
    }

    protected function makeTitle($section, $ui)
    {
        return trans(evaluate_key($section, 'title', null, [$ui]));
    }

    protected function makeFields($section, $ui)
    {
        return [];
    }
}
 