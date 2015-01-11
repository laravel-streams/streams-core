<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Column\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Component\Column\ColumnBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Column\Command\BuildColumns;

/**
 * Class BuildColumnsHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Column\Listener\Command
 */
class BuildColumnsHandler
{

    /**
     * The column builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Component\Column\ColumnBuilder
     */
    protected $builder;

    /**
     * Create a new BuildColumnsHandler instance.
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
     * @param BuildColumns $command
     */
    public function handle(BuildColumns $command)
    {
        $this->builder->build($command->getBuilder());
    }
}
