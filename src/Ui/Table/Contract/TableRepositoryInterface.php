<?php

namespace Anomaly\Streams\Platform\Ui\Table\Contract;

use Illuminate\Support\Collection;

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
     * @return Collection
     */
    public function get();
}
