<?php

namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Platform\Ui\Support\Value;
use Illuminate\Contracts\Support\Arrayable;
use Anomaly\Streams\Platform\Support\Facades\Decorator;
use Anomaly\Streams\Platform\Support\Presenter;

/**
 * Class EntryPresenter
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class EntryPresenter extends Presenter implements Arrayable
{

    /**
     * The resource object.
     * This is for IDE hinting.
     *
     * @var Model
     */
    protected $object;

    /**
     * Create a new EloquentPresenter instance.
     *
     * @param $object
     */
    public function __construct($object)
    {
        $this->object = $object;
    }

    /**
     * Return the ID.
     *
     * @return mixed
     */
    public function id()
    {
        return $this->object->getKey();
    }

    /**
     * Return the object as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->object->toArray();
    }

    /**
     * Return the date string for created at.
     *
     * @return string
     */
    public function createdAtDate()
    {
        return $this->object->created_at
            ->format(config('streams.datetime.date_format'));
    }

    /**
     * Return the datetime string for created at.
     *
     * @return string
     */
    public function createdAtDatetime()
    {
        return $this->object->created_at
            ->format(config('streams.datetime.date_format') . ' ' . config('streams.datetime.time_format'));
    }

    /**
     * Return the date string for updated at.
     *
     * @return string
     */
    public function updatedAtDate()
    {
        return $this->object->updated_at
            ->format(config('streams.datetime.date_format'));
    }

    /**
     * Return the datetime string for updated at.
     *
     * @return string
     */
    public function updatedAtDatetime()
    {
        return $this->object->updated_at
            ->format(config('streams.datetime.date_format') . ' ' . config('streams.datetime.time_format'));
    }

    /**
     * Return the date string for last modified.
     *
     * @return string
     */
    public function lastModifiedDate()
    {
        return $this->object->lastModified()
            ->format(config('streams.datetime.date_format'));
    }

    /**
     * Return the datetime string for last modified.
     *
     * @return string
     */
    public function lastModifiedDatetime()
    {
        return $this->object->lastModified()
            ->format(config('streams.datetime.date_format') . ' ' . config('streams.datetime.time_format'));
    }

    /**
     * Return a label.
     *
     * @param         $text
     * @param  string $context
     * @param  string $size
     * @return string
     */
    public function label($text = null, $context = null, $size = null)
    {
        if (!$text) {
            $text = $this->object->stream->getTitleColumn();
        }

        if (!$context) {
            $context = 'default';
        }

        if (!$size) {
            $size = 'sm';
        }

        /* @var Value $value */
        $value = app(Value::class);

        $text = $value->make($text, $this->object);

        if (trans()->has($text) && is_string(trans($text))) {
            $text = trans($text);
        }

        return '<span class="tag tag-' . $context . ' tag-' . $size . '">' . $text . '</span>';
    }

    /**
     * When accessing a property of a decorated entry
     * object first check to see if the key represents
     * a streams field. If it does then return the field
     * type's presenter object. Otherwise handle normally.
     *
     * @param  $key
     * @return mixed
     */
    public function __get($key)
    {
        if ($field = $this->object->stream()->getField($key)) {

            $type = $field->type();

            $type->setEntry($this->object);

            if (method_exists($type, 'getRelation')) {
                return $type->decorate($this->object->getRelationValue(camel_case($key)));
            }

            $type->setValue($this->object->getFieldValue($key));

            return $type->newPresenter();
        }

        return Decorator::decorate(parent::__get($key));
    }
}
