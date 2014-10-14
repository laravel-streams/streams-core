<?php namespace Streams\Platform\Ui\Table\Command;

use Streams\Platform\Contract\CommandInterface;

class BuildTableButtonsCommandHandler implements CommandInterface
{
    public function handle($command)
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
 