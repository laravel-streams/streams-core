<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command\Handler;

use Anomaly\Streams\Platform\Ui\Table\Component\Filter\Command\BuildFilters;
use Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterBuilder;

/**
 * Class BuildFiltersHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Component\Filter\Listener\Command
 */
class BuildFiltersHandler
{

    /**
     * The filter builder.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Component\Filter\FilterBuilder
     */
    protected $builder;

    /**
     * Create a new BuildFiltersHandler instance.
     *
     * @param FilterBuilder $builder
     */
    public function __construct(FilterBuilder $builder)
    {
        $this->builder = $builder;
    }

    
}
