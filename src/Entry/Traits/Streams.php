<?php

namespace Anomaly\Streams\Platform\Model\Traits;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Illuminate\Support\Facades\App;
use Anomaly\Streams\Platform\Traits\Hookable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Anomaly\Streams\Platform\Traits\Versionable;
use Anomaly\Streams\Platform\Entry\EntryObserver;
use Anomaly\Streams\Platform\Stream\StreamBuilder;
use Anomaly\Streams\Platform\Stream\StreamManager;
use Anomaly\Streams\Platform\Entry\Traits\Presentable;
use Anomaly\Streams\Platform\Entry\Traits\Translatable;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Support\Facades\Streams as StreamsFacade;

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
    use Hookable;
    use Searchable;
    use Presentable;
    use SoftDeletes;
    use Versionable;
    use Translatable;
    use ProvidesQueryBuilders;

    /**
     * Boot the Streams trait. 
     */
    public static function bootStreams()
    {
        if (is_object(self::$stream)) {
            return self::$stream;
        }

        self::$stream['model'] = new static;

        self::$stream = StreamsFacade::make(self::$stream);

        // This works but we don't wnat it. It's a test. Hook works too.
        // @todo finish this
        // ($instance = new static)->bind('get_title_column', function () {
        //     return $this->stream()->title_column;
        // });

        ($instance = new static)->bind('created_by', function () {
            return $this->belongsTo(config('auth.providers.users.model'));
        });

        $instance->bind('fire_event', function ($event) {
            return $this->fireModelEvent($event);
        });

        $instance->bind('fireFieldTypeEvents', function ($event) {
            //return $this->fireModelEvent($event);
        });

        $instance->bind('updated_by', function () {
            return $this->belongsTo(config('auth.providers.users.model'));
        });

        $instance->bind('last_modified', function () {
            return $this->updated_at ?: $this->created_at;
        });

        $instance->bind('get_title', function () {
            return $this->{$this->stream->title_column};
        });

        // From EntryModel
        $class     = get_class($instance);
        $events    = $instance->getObservableEvents();
        $observer  = substr($class, 0, -5) . 'Observer';
        $observing = class_exists($observer);

        if ($events && $observing) {
            self::observe(app($observer));
        }

        if ($events && !$observing) {
            self::observe(EntryObserver::class);
        }
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

        $type->setEntry($this);

        $value = parent::getAttributeValue($fieldSlug);

        if ($field->translatable) {
            // @todo roles for users.. this is obviously not right. 
            // Option handlers and translatable values. 
            $value = Arr::get($value, $this->locale($locale));
        }

        $type->setValue($value);

        return $value;
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        if ($this->stream()->fields->has($key)) {
            return $this->setFieldValue($key, $value);
        }

        return parent::setAttribute($key, $value);
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
        $field = $this->stream()->fields->get($fieldSlug);

        $type = $field->type();

        $type->setEntry($this);

        $key = $type->getColumnName();

        /**
         * !! This messes with translated
         * fields that store arrays !!
         * 
         * Conflict with fill (like seeding)
         * and setting translatable fields.
         * 
         * Test for $this->isLocaleKey(array_keys($value)[0])
         * 
         * @todo The "!in_array" in particular needs revisited.
         */
        if ($field->translatable && !is_array($value)) {
            $value = array_merge((array) $this->{$key}, [
                $this->locale($locale) => $value,
            ]);
        }

        return parent::setAttribute($key, $value);
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
        if ($this->hasHook($hook = Str::snake($method))) {
            return $this->call($hook, $parameters);
        }

        return parent::__call($method, $parameters);
    }
}
