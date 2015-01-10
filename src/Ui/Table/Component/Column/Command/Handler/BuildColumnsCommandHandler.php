<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Column\Command;

use Anomaly\Streams\Platform\Ui\Table\Component\Column\ColumnBuilder;

/**
 * Class BuildColumnsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Column\Listener\Command
 */
class BuildColumnsCommandHandler
{

    /**
     * The column builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Component\Column\ColumnBuilder
     */
    protected $builder;

    /**
     * Create a new BuildColumnsCommandHandler instance.
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
     * @param BuildColumnsCommand $command
     */
    public function handle(BuildColumnsCommand $command)
    {
        $this->builder->build($command->getBuilder());
    }
}
