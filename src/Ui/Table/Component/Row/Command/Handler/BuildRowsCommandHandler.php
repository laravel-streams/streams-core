<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Row\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Component\Row\RowBuilder;

/**
 * Class BuildRowsCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Row\Listener\Command
 */
class BuildRowsCommandHandler
{

    /**
     * The row builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Component\Row\RowBuilder
     */
    protected $builder;

    /**
     * Create a new BuildRowsCommandHandler instance.
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
     * @param BuildRowsCommand $command
     */
    public function handle(BuildRowsCommand $command)
    {
        $this->builder->build($command->getBuilder());
    }
}
