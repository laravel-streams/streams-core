<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class FilterBuilder
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class FilterBuilder
{

    /**
     * Build the filters.
     *
     * @param TableBuilder $builder
     */
    public static function build(TableBuilder $builder)
    {
        $table = $builder->getTable();

        $factory = app(FilterFactory::class);

        FilterInput::read($builder);

        foreach ($builder->getFilters() as $filter) {

            if (array_get($filter, 'enabled') === false) {
                continue;
            }

            $table->addFilter($factory->make($filter));
        }

        if ($first = $builder->getTableFilters()->first()) {
            $first->addAttribute('data-keymap', 'f');
        }
    }
}
