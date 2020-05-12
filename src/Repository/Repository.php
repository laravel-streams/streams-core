<?php

namespace Anomaly\Streams\Platform\Repository;

use Illuminate\Support\Traits\Macroable;
use Anomaly\Streams\Platform\Stream\Stream;
use Anomaly\Streams\Platform\Traits\HasMemory;
use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Anomaly\Streams\Platform\Repository\Contract\RepositoryInterface;
use Filebase\Database;

/**
 * Class Repository
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Repository implements RepositoryInterface
{

    use Macroable;
    use HasMemory;
    use FiresCallbacks;

    protected $stream;

    /**
     * Create a new Repository instance.
     *
     * @param Stream $stream
     */
    public function __construct(Stream $stream)
    {
        $this->stream = $stream;
    }

    /**
     * Return all records.
     *
     * @return Collection
     */
    public function all()
    {
        return $this->newQuery()->all();
    }

    /**
     * Return a new query builder.
     *
     * @return Builder @todo replace correctly
     */
    public function newQuery()
    {
        return new Database([
            'dir' => 'streams/data/' . $this->stream->slug
        ]);
    }
}
