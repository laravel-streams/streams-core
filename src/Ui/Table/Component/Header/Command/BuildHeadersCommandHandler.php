<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Header\Command;

use Anomaly\Streams\Platform\Ui\Table\Component\Header\HeaderBuilder;

/**
 * Class BuildHeadersCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Header\Listener\Command
 */
class BuildHeadersCommandHandler
{

    /**
     * The header builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Component\Header\HeaderBuilder
     */
    protected $builder;

    /**
     * Create a new BuildHeadersCommandHandler instance.
     *
     * @param HeaderBuilder $builder
     */
    public function __construct(HeaderBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Build headers and load them to the table.
     *
     * @param BuildHeadersCommand $command
     */
    public function handle(BuildHeadersCommand $command)
    {
        $this->builder->build($command->getBuilder());
    }
}
