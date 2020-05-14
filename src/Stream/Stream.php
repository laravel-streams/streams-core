<?php

namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Entry\EntryModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Traits\Macroable;
use Anomaly\Streams\Platform\Traits\HasMemory;
use Anomaly\Streams\Platform\Traits\HasAttributes;
use Anomaly\Streams\Platform\Repository\Repository;
use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Repository\Contract\RepositoryInterface;

/**
 * Class Stream
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Stream implements StreamInterface
{

    use Macroable;
    use HasMemory;
    use HasAttributes;
    use FiresCallbacks;

    /**
     * The Stream attributes.
     *
     * @var array
     */
    protected $attributes = [
        'name' => null,
        'slug' => null,
        'description' => null,

        'model' => null,
        'fields' => null,
        'repository' => null,

        'location' => null,

        'config' => [],

        'sortable' => false,
        'trashable' => true,
        'searchable' => true,
        'versionable' => true,
        'translatable' => false,
    ];

    /**
     * Return the entry model.
     * 
     * @param array $attributes
     * @return Model
     */
    public function model(array $attributes = [])
    {
        return (new EntryModel($attributes))
            ->setTable($this->table ?: $this->slug)
            ->setStream($this);
    }

    /**
     * Return the entry repository.
     * 
     * @return RepositoryInterface
     */
    public function repository()
    {
        return new Repository($this);
    }
}
