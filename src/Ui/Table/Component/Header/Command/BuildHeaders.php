<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Header\Command;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\Component\Header\HeaderBuilder;

/**
 * Class BuildHeaders
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 */
class BuildHeaders
{

    /**
     * The table builder.
     *
     * @var TableBuilder
     */
    protected $builder;

    /**
     * Create a new BuildHeaders instance.
     *
     * @param TableBuilder $builder
     */
    public function __construct(TableBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command
     *
     * @param HeaderBuilder $builder
     */
    public function handle(HeaderBuilder $builder)
    {
        $builder->build($this->builder);
    }
}
