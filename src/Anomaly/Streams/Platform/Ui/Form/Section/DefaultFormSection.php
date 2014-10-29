<?php namespace Anomaly\Streams\Platform\Ui\Form\Section;

use Anomaly\Streams\Platform\Ui\Form\FormSection;
use Anomaly\Streams\Platform\Ui\Form\Command\BuildFormSectionLayoutCommand;

class DefaultFormSection extends FormSection
{

    public function heading()
    {
        $title = $this->getTitle();

        return view('html/section/default/heading', compact('title'));
    }

    public function body()
    {
        $body = $this->getBody();

        return view('html/section/default/body', compact('body'));
    }

    protected function getTitle()
    {
        return trans(evaluate_key($this->section, 'title', 'misc.untitled'));
    }

    private function getBody()
    {
        $layout = $this->getLayout();

        return view('html/section/layout', compact('layout'));
    }

    protected function getLayout()
    {
        $command = new BuildFormSectionLayoutCommand($this->ui, $this->section);

        return $this->execute($command);
    }

}
 