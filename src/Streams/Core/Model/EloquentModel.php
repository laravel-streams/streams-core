<?php namespace Streams\Core\Model;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Streams\Core\Traits\CacheableTrait;
use Streams\Core\Traits\ObservableTrait;
use Illuminate\Database\Eloquent\Collection;
use Streams\Core\Contract\PresenterInterface;
use Streams\Core\Contract\ArrayableInterface;
use Streams\Core\Collection\EloquentCollection;
use Venturecraft\Revisionable\RevisionableTrait;
use Streams\Core\Model\Presenter\EloquentPresenter;

class EloquentModel extends Model implements ArrayableInterface, PresenterInterface
{
    use Translatable {
        Translatable::save as translatableSave;
    }

    use RevisionableTrait;
    use CacheableTrait;
    use ObservableTrait;

    /**
     * Translatable attributes.
     *
     * @var array
     */
    protected $translatedAttributes = [];

    /**
     * Validate the model by default.
     *
     * @var boolean
     */
    protected $validate = true;

    /**
     * The number of minutes to cache query results.
     *
     * @var boolean/int
     */
    protected $cacheMinutes = false;

    /**
     * The attributes that are not mass assignable
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Save the model.
     *
     * @param array    $rules
     * @param array    $customMessages
     * @param array    $options
     * @param \Closure $beforeSave
     * @param \Closure $afterSave
     * @return bool
     */
    public function save(
        array $rules = array(),
        array $customMessages = array(),
        array $options = array(),
        \Closure $beforeSave = null,
        \Closure $afterSave = null
    ) {
        if ($this->translatable and $this->translatableSave($options)) {
            return parent::save($rules, $customMessages, $options, $beforeSave, $afterSave);
        } else {
            return parent::save($rules, $customMessages, $options, $beforeSave, $afterSave);
        }

        return false;
    }

    /**
     * Return the is revisionable attribute.
     *
     * @return bool
     */
    public function getIsRevisionableAttribute()
    {
        return isset($this->attributes['is_revisionable']) ? $this->attributes['is_revisionable'] : false;
    }

    /**
     * Return a new collection class with our models.
     *
     * @param array $models
     * @return Collection
     */
    public function newCollection(array $models = array())
    {
        return new EloquentCollection($models);
    }

    /**
     * Get the validate property.
     *
     * @return bool
     */
    public function getValidate()
    {
        return $this->validate;
    }

    /**
     * Set the validate property.
     *
     * @param $validate
     * @return $this
     */
    public function setValidate($validate)
    {
        $this->validate = ($validate);

        return $this;
    }

    /**
     * Return a new resource instance.
     *
     * @param $resource
     * @return EloquentPresenter
     */
    public function newPresenter($resource)
    {
        return new EloquentPresenter($resource);
    }
}
