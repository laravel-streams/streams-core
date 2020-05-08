<?php

namespace Anomaly\Streams\Platform\Stream;

use Illuminate\Support\Traits\Macroable;
use Anomaly\Streams\Platform\Traits\HasMemory;
use Anomaly\Streams\Platform\Traits\HasAttributes;
use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;

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
     * Get a location::key string.
     *
     * @param  null $key
     * @return string
     */
    public function location($key = null)
    {
        if (!$this->location) {
            return $key;
        }

        return $this->location . ($key ? '::' . $key : $key);
    }

    /**
     * Return a config value.
     *
     * @param string $key
     * @param mixed $default
     */
    public function config($key, $default = null)
    {
        return array_get($this->config, $key, $default);
    }

    /**
     * Return the title field.
     *
     * @return null|FieldInterface
     */
    public function titleField()
    {
        return $this->fields->get($this->title_column);
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
