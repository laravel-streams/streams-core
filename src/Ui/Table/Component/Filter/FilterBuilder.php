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
        $factory = app(FilterFactory::class);

        FilterInput::read($builder);

        foreach ($builder->filters as $filter) {

            if (array_get($filter, 'enabled') === false) {
                continue;
            }

            $builder->table->filters->push($factory->make($filter, [
                'stream' => $builder->stream,
            ]));
        }

        if ($first = $builder->table->filters->first()) {
            $first->setAttribute('data-keymap', 'f');
        }
    }
}
