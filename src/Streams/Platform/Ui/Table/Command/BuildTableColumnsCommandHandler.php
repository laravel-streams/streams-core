<?php namespace Streams\Platform\Ui\Table\Command;

use Streams\Platform\Contract\CommandInterface;

class BuildTableColumnsCommandHandler implements CommandInterface
{
    public function handle($command)
    {
        $ui    = $command->getUi();
        $entry = $command->getEntry();

        $columns = evaluate($ui->getColumns(), [$ui, $entry]);

        foreach ($columns as &$column) {

            $data = 'test';

            $column = compact('data');

        }

        return $columns;
    }
}
 