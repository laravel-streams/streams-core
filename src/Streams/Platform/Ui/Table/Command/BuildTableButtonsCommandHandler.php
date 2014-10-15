<?php namespace Streams\Platform\Ui\Table\Command;

class BuildTableButtonsCommandHandler
{
    public function handle(BuildTableButtonsCommand $command)
    {
        $ui    = $command->getUi();
        $entry = $command->getEntry();

        $buttons = evaluate($ui->getButtons(), [$ui, $entry]);

        foreach ($buttons as &$button) {

            $data = 'test';

            $button = compact('data');

        }

        return $buttons;
    }
}
 