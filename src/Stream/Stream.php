<?php

namespace Anomaly\Streams\Platform\Stream;

use Anomaly\Streams\Platform\Field\FieldCollection;
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

    /**
     * The field collection.
     *
     * @var FieldCollection
     */
    public $fields;

    protected $slug;
    protected $title_column;
    protected $sortable = false;
    protected $trashable = true;
    protected $searchable = true;
    protected $versionable = true;

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
     * Get the name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Get the description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the config.
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Merge configuration.
     *
     * @param  array $config
     * @return $this
     */
    public function mergeConfig(array $config)
    {
        $this->config = array_merge($this->config, $config);

        return $this;
    }

    /**
     * Get the sortable flag.
     *
     * @return bool
     */
    public function isSortable()
    {
        return $this->sortable;
    }

    /**
     * Get the searchable flag.
     *
     * @return bool
     */
    public function isSearchable()
    {
        return $this->searchable;
    }

    /**
     * Get the trashable flag.
     *
     * @return bool
     */
    public function isTrashable()
    {
        return $this->trashable;
    }

    /**
     * Get the versionable flag.
     *
     * @return bool
     */
    public function isVersionable()
    {
        return $this->versionable;
    }

    /**
     * Get the translatable flag.
     *
     * @return bool
     */
    public function isTranslatable()
    {
        return $this->translatable;
    }

    /**
     * Get the title column.
     *
     * @return string
     */
    public function getTitleColumn()
    {
        return $this->titlecolumn;
    }

    /**
     * Get the title field.
     *
     * @return null|FieldInterface
     */
    public function getTitleField()
    {
        return $this->titlefield;
    }

    /**
     * Get an by it's field's slug.
     *
     * @param  $slug
     * @return FieldInterface
     */
    public function getField($slug)
    {
        return $this->field;
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
