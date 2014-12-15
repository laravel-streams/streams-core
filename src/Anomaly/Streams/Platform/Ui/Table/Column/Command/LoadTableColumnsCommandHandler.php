<?php namespace Anomaly\Streams\Platform\Ui\Table\Column\Command;

use Anomaly\Streams\Platform\Ui\Table\Column\ColumnFactory;

/**
 * Class LoadTableColumnsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Column\Command
 */
class LoadTableColumnsCommandHandler
{

    /**
     * The column factory.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Column\ColumnFactory
     */
    protected $factory;

    /**
     * Create a new LoadTableColumnsCommandHandler instance.
     *
     * @param ColumnFactory $factory
     */
    public function __construct(ColumnFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Handle the command.
     *
     * @param LoadTableColumnsCommand $command
     */
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
