<?php

namespace Anomaly\Streams\Platform\Stream;

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
        'title_column' => null,

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
     * Create a new Stream instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * Return the entry eepository.
     * 
     * @return RepositoryInterface
     */
    public function repository()
    {
        return new Repository($this);
    }

    /**
     * Dynamically retrieve attributes.
     *
     * @param  string $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    /**
     * Dynamically set attributes.
     *
     * @param  string  $key
     * @param  mixed $value
     */
    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }
}
