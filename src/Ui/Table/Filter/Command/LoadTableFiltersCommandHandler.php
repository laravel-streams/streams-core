<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Command;

use Anomaly\Streams\Platform\Ui\Table\Filter\FilterFactory;

/**
 * Class LoadTableFiltersCommandHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Filter\Command
 */
class LoadTableFiltersCommandHandler
{

    /**
     * The filter factory.
     *
     * @var \Anomaly\Streams\Platform\Ui\Table\Filter\FilterFactory
     */
    protected $factory;

    /**
     * Create a new LoadTableFiltersCommandHandler instance.
     *
     * @param FilterFactory $factory
     */
    public function __construct(FilterFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Handle the command.
     *
     * @param LoadTableFiltersCommand $command
     */
    public function handle(LoadTableFiltersCommand $command)
    {
        $builder = $command->getBuilder();
        $table   = $builder->getTable();
        $filters = $table->getFilters();

        foreach ($builder->getFilters() as $parameters) {
            array_set($parameters, 'stream', $table->getStream());

            $filter = $this->factory->make($parameters);

            $filter->setPrefix($table->getPrefix());
            $filter->setActive(app('request')->has($table->getPrefix() . $filter->getSlug()));

            $filters->put($filter->getSlug(), $filter);
        }
    }
}
