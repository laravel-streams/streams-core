<?php namespace Anomaly\Streams\Platform\Ui\Table\Row\Command;

use Anomaly\Streams\Platform\Ui\Table\Row\RowBuilder;

/**
 * Class BuildTableRowsCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Row\Command
 */
class BuildTableRowsCommandHandler
{

    /**
     * The row builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Row\RowBuilder
     */
    protected $builder;

    /**
     * Create a new TableLoadListener instance.
     *
     * @param RowBuilder $builder
     */
    public function __construct(RowBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Build rows and load them to the table.
     *
     * @param BuildTableRowsCommand $command
     */
    public function handle(BuildTableRowsCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();

        foreach ($table->getEntries() as $entry) {
            $this->builder->load($builder, $entry);
        }
    }
}
