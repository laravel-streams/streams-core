<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Contract\PresentableInterface;
use Anomaly\Streams\Platform\Traits\CommandableTrait;

/**
 * Class BuildTableRowsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Command
 */
class BuildTableRowsCommandHandler
{

    use CommandableTrait;

    /**
     * Handle the command.
     *
     * @param BuildTableRowsCommand $command
     * @return array
     */
    public function handle(BuildTableRowsCommand $command)
    {
        $rows = [];

        $table = $command->getTable();

        foreach ($table->getEntries() as $entry) {

            // Build out our required data.
            $columns = $this->getColumns($entry, $table);
            $buttons = $this->getButtons($entry, $table);
            $entry   = $this->getDecoratedEntry($entry);

            $rows[] = compact('columns', 'buttons', 'entry');
        }

        return $rows;
    }

    /**
     * Get our column data for each row.
     *
     * @param $entry
     * @param $table
     * @return mixed
     */
    protected function getColumns($entry, $table)
    {
        $command = new BuildTableColumnsCommand($table, $entry);

        return $this->execute($command);
    }

    /**
     * Get our button data for each row.
     *
     * @param $entry
     * @param $table
     * @return mixed
     */
    protected function getButtons($entry, $table)
    {
        $command = new BuildTableButtonsCommand($table, $entry);

        return $this->execute($command);
    }

    /**
     * Decorate the entry before sending it to the view.
     * Typically this would be auto-decorated but
     * it is buried a little in this case.
     *
     * @param $entry
     * @return mixed
     */
    protected function getDecoratedEntry($entry)
    {
        if ($entry instanceof PresentableInterface) {

            $entry = $entry->decorate();
        }

        return $entry;
    }
}
 