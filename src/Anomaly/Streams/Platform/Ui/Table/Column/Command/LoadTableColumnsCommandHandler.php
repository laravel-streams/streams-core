<?php namespace Anomaly\Streams\Platform\Ui\Table\Column\Command;

use Anomaly\Streams\Platform\Ui\Table\Column\ColumnFactory;

class LoadTableColumnsCommandHandler
{
    protected $factory;

    public function __construct(ColumnFactory $factory)
    {
        $this->factory = $factory;
    }

    public function handle(LoadTableColumnsCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();
        $columns = $table->getColumns();

        foreach ($builder->getColumns() as $parameters) {
            array_set($parameters, 'stream', $table->getStream());

            $column = $this->factory->make($parameters);

            $column->setPrefix($table->getPrefix());

            $columns->push($column);
        }
    }
}
