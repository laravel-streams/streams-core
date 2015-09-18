<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Header\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Component\Header\Command\BuildHeaders;
use Anomaly\Streams\Platform\Ui\Table\Component\Header\HeaderBuilder;

/**
 * Class BuildHeadersHandler.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Header\Listener\Command
 */
class BuildHeadersHandler
{
    /**
     * The header builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Component\Header\HeaderBuilder
     */
    protected $builder;

    /**
     * Create a new BuildHeadersHandler instance.
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
     * @param BuildHeaders $command
     */
    public function handle(BuildHeaders $command)
    {
        $this->builder->build($command->getBuilder());
    }
}
