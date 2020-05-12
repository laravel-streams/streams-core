<?php

namespace Anomaly\Streams\Platform\Repository;

use Filebase\Document;
use Filebase\Database;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;
use Anomaly\Streams\Platform\Entry\Entry;
use Anomaly\Streams\Platform\Stream\Stream;
use Anomaly\Streams\Platform\Traits\HasMemory;
use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Repository\Contract\RepositoryInterface;

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
        return $this->collect($this->newQuery()->results());
    }

    /**
     * Find an entry by ID.
     *
     * @param $id
     * @return null|EntryInterface
     */
    public function find($id)
    {
        return $this->make($this->newQuery()->get($id));
    }

    /**
     * Return a new query builder.
     *
     * @return Builder @todo replace correctly
     */
    public function newQuery()
    {
        return new Database([
            'dir' => base_path('streams/data/' . $this->stream->slug)
        ]);
    }

    /**
     * Return an entry collection.
     *
     * @param array $entries
     * @return Collection
     */
    protected function collect(array $entries)
    {
        $collection = $this->stream->attr('collection', Collection::class);

        return new $collection(array_map(function (array $attributes) {
            return new Entry($attributes, $this->stream);
        }, $entries));
    }

    /**
     * Return an entry instance.
     *
     * @param Document $data
     * @return EntryInterface
     */
    protected function make(Document $data)
    {
        $abstract = $this->stream->attr('abstract', Entry::class);

        return new $abstract(array_merge(['id' => $data->getId()], $data->toArray()), $this->stream);
    }
}
