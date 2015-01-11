<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Row\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Component\Row\Command\BuildRows;
use Anomaly\Streams\Platform\Ui\Table\Component\Row\RowBuilder;

/**
 * Class BuildRowsHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Row\Listener\Command
 */
class BuildRowsHandler
{

    /**
     * The row builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Component\Row\RowBuilder
     */
    protected $builder;

    /**
     * Create a new BuildRowsHandler instance.
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
     * @param BuildRows $command
     */
    public function handle(BuildRows $command)
    {
        $this->builder->build($command->getBuilder());
    }
}
