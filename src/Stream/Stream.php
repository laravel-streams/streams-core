<?php

namespace Anomaly\Streams\Platform\Stream;

use Illuminate\Support\Traits\Macroable;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Traits\HasMemory;
use Anomaly\Streams\Platform\Field\FieldCollection;
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
    use FiresCallbacks;

    /**
     * The field collection.
     *
     * @var FieldCollection
     */
    public $fields;

    /**
     * The stream model.
     *
     * @var EntryModel
     */
    public $model;

    public $name;
    public $slug;
    public $description;

    public $location;
    public $title_column;

    public $config = [];

    public $sortable = false;
    public $trashable = true;
    public $searchable = true;
    public $versionable = true;
    public $translatable = false;

    /**
     * Create a new Stream instance.
     *
     * @param array $stream
     */
    public function __construct($stream)
    {
        foreach ($stream as $attribute => $value) {
            $this->{$attribute} = $value;
        }
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
     * Get an by it's field's slug.
     *
     * @param  $slug
     * @return FieldInterface
     */
    public function getField($slug)
    {
        return $this->fields->get($slug);
    }

    /**
     * Return whether a stream
     * has a field assigned.
     *
     * @param $slug
     * @return bool
     */
    public function hasField($slug)
    {
        return $this->fields->has($slug);
    }
}
