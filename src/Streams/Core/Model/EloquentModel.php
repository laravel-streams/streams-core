<?php namespace Streams\Core\Model;

use Streams\Core\Traits\CacheableTrait;
use Streams\Core\Traits\ObservableTrait;
use Dimsav\Translatable\Translatable;
use Streams\Core\Contract\PresenterInterface;
use Streams\Core\Contract\ArrayableInterface;
use Streams\Core\Collection\EloquentCollection;
use Illuminate\Database\Eloquent\Collection;
use Streams\Core\Model\Presenter\EloquentPresenter;
use Venturecraft\Revisionable\RevisionableTrait;

class EloquentModel extends ArdentModel implements ArrayableInterface, PresenterInterface
{
    /*use Translatable {
        Translatable::save as translatableSave;
    }*/

    /*use RevisionableTrait;*/
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
     * @param array $rules
     * @param array $customMessages
     * @param array $options
     * @param \Closure $beforeSave
     * @param \Closure $afterSave
     * @return bool
     */
    /*public function save(
        array $rules = array(),
        array $customMessages = array(),
        array $options = array(),
        \Closure $beforeSave = null,
        \Closure $afterSave = null
    ) {
        if ($this->translatableSave($options)) {
            return parent::save($rules, $customMessages, $options, $beforeSave, $afterSave);
        }

        return false;
    }*/

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
