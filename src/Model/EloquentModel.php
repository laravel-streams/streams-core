<?php

namespace Anomaly\Streams\Platform\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Collection;
use Anomaly\Streams\Platform\Traits\Hookable;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Anomaly\Streams\Platform\Traits\HasMemory;
use Anomaly\Streams\Platform\Model\Traits\Versionable;
use Anomaly\Streams\Platform\Model\Traits\Translatable;
use Anomaly\Streams\Platform\Model\Contract\EloquentInterface;
use Anomaly\Streams\Platform\Presenter\Contract\PresentableInterface;

/**
 * Class EloquentModel
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class EloquentModel extends Model implements EloquentInterface, Arrayable, PresentableInterface
{
    use Hookable;
    use Translatable;
    use DispatchesJobs;

    /**
     * Disable timestamps for this model.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are
     * not mass assignable. Let upper
     * models handle this themselves.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The translation model name.
     *
     * @var null
     */
    protected $translationModel = null;

    /**
     * Observable model events.
     *
     * @var array
     */
    protected $observables = [
        'updatingMultiple',
        'updatedMultiple',
        'deletingMultiple',
        'deletedMultiple',
    ];

    /**
     * The cascading delete-able relations.
     *
     * @var array
     */
    protected $cascades = [];

    /**
     * The restricting delete-able relations.
     *
     * @var array
     */
    protected $restricts = [];

    /**
     * Runtime cache.
     *
     * @var array
     */
    protected static $cache = [];

    /**
     * Get the ID.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return the entry presenter.
     *
     * This is against standards but required
     * by the presentable interface.
     *
     * @return EloquentPresenter
     */
    public function newPresenter()
    {
        $presenter = substr(get_class($this), 0, -5) . 'Presenter';

        if (class_exists($presenter)) {
            return app()->make($presenter, ['object' => $this]);
        }

        return new EloquentPresenter($this);
    }

    /**
     * Return a new collection class with our models.
     *
     * @param  array $items
     * @return Collection
     */
    public function newCollection(array $items = [])
    {
        $collection = substr(get_class($this), 0, -5) . 'Collection';

        if (class_exists($collection)) {
            return new $collection($items);
        }

        return new EloquentCollection($items);
    }

    /**
     * Return whether the model is being
     * force deleted or not.
     *
     * @return bool
     */
    public function isForceDeleting()
    {
        return isset($this->forceDeleting) && $this->forceDeleting === true;
    }

    /**
     * Fire a model event.
     *
     * @param string $event
     */
    public function fireEvent($event)
    {
        $this->fireModelEvent($event);
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function newEloquentBuilder($query)
    {
        $builder = substr(get_class($this), 0, -5) . 'QueryBuilder';

        if (class_exists($builder)) {
            return new $builder($query);
        }

        return new EloquentQueryBuilder($query);
    }

    /**
     * Get an attribute.
     *
     * @param string $key
     * @param string|null $locale
     * @return mixed|null
     */
    public function getAttribute($key)
    {
        if ($this->isTranslatedAttribute($key)) {
            return parent::getAttribute($key)[$this->locale()];
        }

        return parent::getAttribute($key);
    }

    /**
     * Set an attribute.
     *
     * @param  string $key
     * @param  mixed $value
     * @param  string|null $locale
     * @return $this
     */
    public function setAttribute($key, $value, $locale = null)
    {
        if ($this->isTranslatedAttribute($key)) {
            return parent::setAttribute($key . '->' . app()->getLocale(), $value);
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Perform any actions that are necessary after the model is saved.
     *
     * @param  array $options
     * @return void
     */
    protected function finishSave(array $options)
    {
        if (($options['version'] ?? true) == false && $this instanceof Versionable) {
            $this->disableVersioning();
        }

        parent::finishSave($options);
    }

    /**
     * Fill the model attributes.
     *
     * @param array $attributes
     * @return $this
     */
    public function fill(array $attributes)
    {
        foreach ($this->getTranslatedAttributes() as $key) {

            if (isset($attributes[$key]) && !is_array($attributes[$key])) {

                array_set($attributes, $key . '->' . config('app.fallback_locale'), array_pull($attributes, $key));

                continue;
            }

            if (isset($attributes[$key]) && is_array($attributes[$key])) {

                foreach (array_pull($attributes, $key) as $locale => $value) {
                    array_set($attributes, $key . '->' . $locale, $value);
                }

                continue;
            }
        }

        return parent::fill($attributes);
    }

    /**
     * Return unguarded attributes.
     *
     * @return array
     */
    public function getUnguardedAttributes()
    {
        foreach ($attributes = $this->getAttributes() as $attribute => $value) {
            $attributes[$attribute] = $value;
        }

        return array_diff_key($attributes, array_flip($this->getGuarded()));
    }

    /**
     * Get the default locale.
     *
     * @return string
     */
    protected function getDefaultLocale()
    {
        if (isset(self::$cache['default_locale'])) {
            return self::$cache['default_locale'];
        }

        return self::$cache['default_locale'] = config('streams::locales.default');
    }

    /**
     * Get the fallback locale.
     *
     * @return string
     */
    protected function getFallbackLocale()
    {
        if (isset(self::$cache['fallback_locale'])) {
            return self::$cache['fallback_locale'];
        }

        return self::$cache['fallback_locale'] = config('app.fallback_locale');
    }

    /**
     * This is to keep consistency with the
     * entry interface above us.
     *
     * @return string
     */
    public function getTableName()
    {
        return $this->getTable();
    }

    /**
     * Return the model as an array.
     *
     * @return array
     */
    public function toArray()
    {
        $attributes = $this->attributesToArray();

        return $attributes;
    }

    /**
     * Return the model as an array with relations.
     *
     * @return array
     */
    public function toArrayWithRelations()
    {
        return array_merge(
            $this->toArray(),
            $this->relationsToArray()
        );
    }

    /**
     * Return the object as an
     * array for comparison.
     *
     * @return array
     */
    public function toArrayForComparison()
    {
        $array = array_diff_key(
            $this->toArrayWithRelations(),
            array_flip(['id', 'sort_order', 'created_at', 'updated_at', 'created_by_id', 'updated_by_id'])
        );

        foreach ($this->getRelations() as $attribute => $relation) {
            if ($relation instanceof Collection) {
                foreach ($relation as $index => $model) {

                    /* @var EloquentModel $model */
                    $array[$attribute][$index] = array_diff_key(
                        $model->toArrayWithRelations(),
                        array_flip(['id', 'sort_order', 'created_at', 'updated_at', 'created_by_id', 'updated_by_id'])
                    );
                }
            }

            if ($relation instanceof EloquentModel) {

                /* @var EloquentModel $relation */
                $array[$attribute] = array_diff_key(
                    $relation->toArrayWithRelations(),
                    array_flip(['id', 'sort_order', 'created_at', 'updated_at', 'created_by_id', 'updated_by_id'])
                );
            }
        }

        array_walk(
            $array,
            function ($value, $key) use (&$array) {

                /**
                 * Make sure any nested arrays are serialized.
                 */
                if (is_array($value)) {
                    $array[$key] = json_encode($value);
                }
            }
        );

        return $array;
    }

    /**
     * Return the routable array information.
     *
     * @return array
     */
    public function toRoutableArray()
    {
        return $this->toArray();
    }

    /**
     * We protect things a little
     * differently so open er up.
     *
     * @return bool
     */
    private function alwaysFillable()
    {
        return false;
    }

    /**
     * Get the criteria class.
     *
     * @return string
     */
    public function getCriteriaName()
    {
        $criteria = substr(get_class($this), 0, -5) . 'Criteria';

        return class_exists($criteria) ? $criteria : EloquentCriteria::class;
    }

    /**Fast?
     * Get the cascading actions.
     *
     * @return array
     */
    public function getCascades()
    {
        return $this->cascades;
    }

    /**
     * Get the restricting actions.
     *
     * @return array
     */
    public function getRestricts()
    {
        return $this->restricts;
    }

    /**
     * Check hooks for the missing key.
     *
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        if ($this->hasHook($hook = 'get_' . $key)) {
            return $this->call($hook, []);
        }

        return parent::__get($key);
    }

    /**
     * Check hooks for the missing method.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if ($this->hasHook($hook = snake_case($method))) {
            return $this->call($hook, $parameters);
        }

        return parent::__call($method, $parameters);
    }

    /**
     * Return the string form of the model.
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->toArray());
    }
}
