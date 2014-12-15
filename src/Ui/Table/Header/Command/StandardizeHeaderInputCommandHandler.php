<?php namespace Anomaly\Streams\Platform\Ui\Table\Header\Command;

/**
 * Class StandardizeHeaderInputCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Header\Command
 */
class StandardizeHeaderInputCommandHandler
{

    /**
     * Handle the command.
     *
     * @param StandardizeHeaderInputCommand $command
     */
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
