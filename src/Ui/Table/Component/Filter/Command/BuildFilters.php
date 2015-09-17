<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterBuilder;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class BuildFilters.
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command
 */
class BuildFilters implements SelfHandling
{
    /**
     * The table builder.
     *
     * @var TableBuilder
     */
    protected $builder;

    /**
     * Create a new BuildFilters instance.
     *
     * @param TableBuilder $builder
     */
    public function __construct(TableBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     *
     * @param FilterBuilder $builder
     */
    public function handle(FilterBuilder $builder)
    {
        $builder->build($this->builder);
    }
}
