<?php namespace Anomaly\Streams\Platform\Ui\Table\Row\Command;

use Anomaly\Streams\Platform\Ui\Table\Row\RowFactory;

class LoadTableRowsCommandHandler
{
    protected $factory;

    public function __construct(RowFactory $factory)
    {
        $this->factory = $factory;
    }

    public function handle(LoadTableRowsCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();
        $entries = $table->getEntries();
        $columns = $table->getColumns();
        $buttons = $table->getButtons();
        $rows    = $table->getRows();

        foreach ($entries as $entry) {
            $row = $this->factory->make(compact('entry', 'columns', 'buttons'));

            $rows->push($row);
        }
    }
}
