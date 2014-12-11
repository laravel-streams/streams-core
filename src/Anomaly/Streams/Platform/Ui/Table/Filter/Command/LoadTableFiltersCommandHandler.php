<?php namespace Anomaly\Streams\Platform\Ui\Table\Filter\Command;

use Anomaly\Streams\Platform\Ui\Table\Filter\FilterFactory;

class LoadTableFiltersCommandHandler
{
    protected $factory;

    public function __construct(FilterFactory $factory)
    {
        $this->factory = $factory;
    }

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
