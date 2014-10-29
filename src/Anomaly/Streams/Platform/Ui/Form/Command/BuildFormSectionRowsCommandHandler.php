<?php namespace Anomaly\Streams\Platform\Ui\Form\Command;

use Anomaly\Streams\Platform\Ui\Form\FormUtility;
use Anomaly\Streams\Platform\Traits\CommandableTrait;

class BuildFormSectionRowsCommandHandler
{

    use CommandableTrait;

    protected $utility;

    function __construct(FormUtility $utility)
    {
        $this->utility = $utility;
    }

    public function handle(BuildFormSectionRowsCommand $command)
    {
        $ui = $command->getUi();

        $entry = $ui->getEntry();

        $rows = [];

        foreach ($command->getRows() as $row) {

            // Evaluate the entire row.
            // All first level closures on are gone now.
            $row = $this->utility->evaluate($row, [$ui, $entry], $entry);

            $command = new BuildFormSectionColumnsCommand($ui, $row['columns']);

            $columns = $this->execute($command);

            $rows[] = compact('columns');

        }

        return $rows;
    }

}
 