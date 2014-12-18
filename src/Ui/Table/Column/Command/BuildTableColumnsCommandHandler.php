<?php namespace Anomaly\Streams\Platform\Ui\Table\Column\Command;

use Anomaly\Streams\Platform\Ui\Table\Column\ColumnBuilder;

/**
 * Class BuildTableColumnsCommandHandler
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Column\Command
 */
class BuildTableColumnsCommandHandler
{

    /**
     * The column builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Column\ColumnBuilder
     */
    protected $builder;

    /**
     * Create a new BuildTableColumnsCommandHandler instance.
     *
     * @param ColumnBuilder $builder
     */
    public function __construct(ColumnBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Build columns and load them to the table.
     *
     * @param BuildTableColumnsCommand $command
     */
    public function handle(BuildTableColumnsCommand $command)
    {
        $this->builder->load($command->getBuilder());
    }
}
