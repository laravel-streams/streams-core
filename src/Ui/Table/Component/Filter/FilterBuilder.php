<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Filter;

use Illuminate\Support\Facades\Request;
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

            $builder->table->filters->push($filter = $factory->make($filter, [
                'stream' => $builder->stream,
            ]));

            // @todo should this be "guessed" prior?
            $filter->active = (bool) $builder->request($filter->getInputName());
        }

        if ($first = $builder->table->filters->first()) {
            $first->setAttribute('data-keymap', 'f');
        }
    }
}
