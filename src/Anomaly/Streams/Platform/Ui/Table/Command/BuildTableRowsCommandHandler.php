<?php namespace Anomaly\Streams\Platform\Ui\Table\Command;

use Anomaly\Streams\Platform\Contract\ArrayableInterface;
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

        /**
         * Loop and process entry rows.
         */
        foreach ($table->getEntries() as $entry) {

            $columns = $this->getColumns($entry, $table);
            $buttons = $this->getButtons($entry, $table);

            if ($entry instanceof ArrayableInterface) {

                $entry = $entry->toArray();
            }

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
        return $this->execute(new BuildTableColumnsCommand($table, $entry));
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
        return $this->execute(new BuildTableButtonsCommand($table, $entry));
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

            $entry = $entry->newPresenter();
        }

        return $entry;
    }
}
 