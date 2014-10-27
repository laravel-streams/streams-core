<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Traits\CommandableTrait;

class BuildTableRowsCommandHandler
{
    use CommandableTrait;

    public function handle(BuildTableRowsCommand $command)
    {
        $rows = [];

        $ui = $command->getUi();

        foreach ($ui->getEntries() as $entry) {

            $columns = $this->makeColumns($entry, $ui);
            $buttons = $this->makeButtons($entry, $ui);

            $rows[] = compact('columns', 'buttons', 'entry');

        }

        return $rows;
    }

    protected function makeColumns($entry, $ui)
    {
        $command = new BuildTableColumnsCommand($ui, $entry);

        return $this->execute($command);
    }

    private function makeButtons($entry, $ui)
    {
        $command = new BuildTableButtonsCommand($ui, $entry);

        return $this->execute($command);
    }
}
 