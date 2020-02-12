<?php

namespace Anomaly\Streams\Platform\Model\Traits;

use Anomaly\Streams\Platform\Stream\StreamBuilder;
use Anomaly\Streams\Platform\Stream\StreamManager;
use Anomaly\Streams\Platform\Traits\FiresCallbacks;
use Anomaly\Streams\Platform\Traits\Hookable;
use Exception;
use Illuminate\Support\Traits\Macroable;

/**
 * Class Streams
 *
 * @property array $stream
 * 
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait Streams
{
    //use Hookable; // @todo remove commenting when models removed (full trait)

    /**
     * Boot the Streams trait. 
     */
    public static function bootStreams()
    {
        if (is_object(self::$stream)) {
            return self::$stream;
        }

        self::$stream['model'] = new static;

        StreamManager::put(self::class, self::$stream = StreamBuilder::build(self::$stream));

        // This works but we don't wnat it. It's a test. Hook works too.
        // @todo finish this
        // ($instance = new static)->bind('get_title_column', function () {
        //     return $this->stream()->getTitleColumn();
        // });

        ($instance = new static)->bind('created_by', function () {
            return $this->belongsTo(config('auth.providers.users.model'));
        });

        $instance->bind('updated_by', function () {
            return $this->belongsTo(config('auth.providers.users.model'));
        });

        $instance->bind('last_modified', function () {
            return $this->updated_at ?: $this->created_at;
        });

        $instance->bind('get_title', function () {
            return $this->{$this->stream->getTitleColumn()};
        });
    }

    /**
     * Return the magic.
     *
     * @return StreamInterface
     */
    public function stream()
    {
        return self::$stream;
    }

    /**
     * Get a field value.
     *
     * @param        $fieldSlug
     * @param  null $locale
     * @return mixed
     */
    public function getFieldValue($fieldSlug, $locale = null)
    {
        if (!$field = $this->stream()->fields->get($fieldSlug)) {
            throw new Exception("Field [{$fieldSlug}] not found.");
        }

        $type = $field->type();

        $modifier = $type->getModifier();

        $type->setEntry($this);

        $value = parent::getAttributeValue($fieldSlug);

        if ($field->translatable) {
            $value = $value[$this->locale($locale)];
        }

        $value = $modifier->restore($value);

        $type->setValue($value);

        return $value;
    }

    /**
     * Set a field value.
     *
     * @param        $fieldSlug
     * @param        $value
     * @param  null $locale
     * @return $this
     */
    public function setFieldValue($fieldSlug, $value, $locale = null)
    {
        $assignment = $this->getAssignment($fieldSlug);

        $type = $assignment->getFieldType($this);

        $type->setEntry($this);

        $modifier = $type->getModifier();

        $key = $type->getColumnName();

        if ($assignment->isTranslatable()) {
            $key = $key . '->' . ($locale ?: app()->getLocale());
        }

        return parent::setAttribute($key, $modifier->modify($value));
    }

    /**
     * Pass attributes through streams.
     *
     * @param string $key
     */
    public function __get($key)
    {
        if ($key === 'stream') {
            return $this->stream();
        }

        if ($this->hasHook($hook = 'get_' . $key)) {
            return $this->call($hook, []);
        }

        // Check if it's a relationship first.
        // @todo remove this hardcoded relationship check.
        if (in_array($key, ['created_by', 'updated_by', 'roles'])) {
            return parent::getRelationValue($key);
        }

        if (!$this->hasGetMutator($key) && $this->stream()->fields->has($key)) {
            return $this->getFieldValue($key);
        }

        return parent::getAttribute($key);
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if ($this->hasHook($hook = camel_case($method))) {
            return $this->call($hook, $parameters);
        }

        return parent::__call($method, $parameters);
    }
}
