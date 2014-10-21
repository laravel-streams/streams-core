<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

class BuildTableColumnsCommandHandler
{
    public function handle(BuildTableColumnsCommand $command)
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
 