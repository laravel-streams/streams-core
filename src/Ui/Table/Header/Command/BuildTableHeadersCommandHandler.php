<?php namespace Anomaly\Streams\Platform\Ui\Table\Header\Command;

use Anomaly\Streams\Platform\Ui\Table\Header\HeaderBuilder;

/**
 * Class BuildTableHeadersCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Header\Command
 */
class BuildTableHeadersCommandHandler
{

    /**
     * The header builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Header\HeaderBuilder
     */
    protected $builder;

    /**
     * Create a new TableLoadListener instance.
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
     * @param BuildTableHeadersCommand $command
     */
    public function handle(BuildTableHeadersCommand $command)
    {
        $this->builder->load($command->getBuilder());
    }
}
