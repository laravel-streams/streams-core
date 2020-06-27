<?php

namespace Anomaly\Streams\Platform\Stream\Contract;

use Illuminate\Database\Eloquent\Model;
use Anomaly\Streams\Platform\Repository\Contract\RepositoryInterface;

/**
 * Interface StreamInterface
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
interface StreamInterface
{

    /**
     * Return the entry repository.
     * 
     * @return RepositoryInterface
     */
    public function repository();
}
