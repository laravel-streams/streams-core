<?php namespace Anomaly\Streams\Platform\Ui\Table\Column\Command;

class StandardizeColumnInputCommandHandler
{

    public function handle(StandardizeColumnInputCommand $command)
    {
        $builder = $command->getBuilder();

        $columns = [];

        foreach ($builder->getColumns() as $column) {

            /**
             * If the key is numeric and the column is not
             * an array then use the column as the value.
             */
            if (!is_array($column)) {

                $column = [
                    'header' => $column,
                    'value'  => $column,
                ];
            }

            $columns[] = $column;
        }

        $builder->setColumns($columns);
    }
}
 