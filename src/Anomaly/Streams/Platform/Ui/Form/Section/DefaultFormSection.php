<?php namespace Anomaly\Streams\Platform\Ui\Form\Section;

use Anomaly\Streams\Platform\Ui\Form\Command\BuildFormSectionLayoutCommand;
use Anomaly\Streams\Platform\Ui\Form\FormSection;

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
        $command = new BuildFormSectionLayoutCommand($this->ui, $this->section);

        $layout = $this->execute($command);

        // TODO: Send in compact('layout') when Lexicon is fixed.
        return view('html/section/layout', $layout);
    }

}
 