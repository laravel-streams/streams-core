<?php

namespace Anomaly\Streams\Platform\Ui\Table\Contract;

use Illuminate\Support\Collection;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Interface TableRepositoryInterface
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
interface TableRepositoryInterface
{

    /**
     * Get the table entries.
     *
     * @param  TableBuilder $builder
     * @return Collection
     */
    public function get(TableBuilder $builder);
}
