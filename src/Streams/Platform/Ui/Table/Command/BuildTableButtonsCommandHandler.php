<?php namespace Streams\Platform\Ui\Table\Command;

use Streams\Platform\Contract\HandlerInterface;

class BuildTableButtonsHandlerHandler implements HandlerInterface
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
 