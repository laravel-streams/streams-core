<?php namespace Anomaly\Streams\Platform\Ui\Table\Header\Command;

class StandardizeHeaderInputCommandHandler
{
    public function handle(StandardizeHeaderInputCommand $command)
    {
        $builder = $command->getBuilder();

        $columns = [];

        foreach ($builder->getColumns() as $column) {
            if (isset($column['header']) && is_string($column['header'])) {
                $column['header'] = ['text' => $column['header']];
            }

            $columns[] = $column;
        }

        $builder->setColumns($columns);
    }
}
