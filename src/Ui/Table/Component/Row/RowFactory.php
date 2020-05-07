<?php

namespace Anomaly\Streams\Platform\Ui\Table\Component\Row;

use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Container\Container;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;

/**
 * Class RowFactory
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class RowFactory
{

    /**
     * Make a row.
     *
     * @param  array        $parameters
     * @return Row
     */
    public function make(array $parameters)
    {
        $row = App::make(Row::class, $parameters);

        Hydrator::hydrate($row, $parameters);

        return $row;
    }
}
