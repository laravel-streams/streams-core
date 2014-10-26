<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

class BuildTableButtonsCommandHandler
{

    public function handle(BuildTableButtonsCommand $command)
    {
        $ui    = $command->getUi();
        $entry = $command->getEntry();

        $buttons = [];

        foreach ($ui->getButtons() as $button) {

            $text  = $this->makeText($button, $ui, $entry);
            $class = $this->makeClass($button, $ui, $entry);
            $href  = $this->makeUrl($button, $ui, $entry);

            $buttons[] = compact('text', 'href', 'class');

        }

        return $buttons;
    }

    protected function makeText($button, $ui, $entry)
    {
        return trans(evaluate_key($button, 'text', null, [$ui, $entry]));
    }

    private function makeClass($button, $ui, $entry)
    {
        $class = evaluate_key($button, 'class', 'btn btn-sm btn-default', [$ui, $entry]);

        return $class;
    }

    protected function makeUrl($button, $ui, $entry)
    {
        $url = evaluate_key($button, 'url', null, [$ui, $entry]);

        if (!starts_with($url, 'http')) {

            $url = url($url);

        }

        return $url;
    }

}
 