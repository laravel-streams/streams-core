<?php namespace Streams\Core\Entry\Model;

use Streams\Core\Model\EloquentModel;
use Streams\Core\Stream\Model\StreamModel;
use Streams\Core\Entry\Presenter\EntryPresenter;
use Streams\Core\Entry\Collection\EntryCollection;

class EntryModel extends EloquentModel
{
    /**
     * Stream data
     *
     * @var array/null
     */
    protected $stream = [];

    /**
     * Return the default columns.
     *
     * @return array
     */
    public function defaultColumns()
    {
        return [$this->getKeyName(), $this->CREATED_AT, 'createdByUser'];
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return void
     */
    public function setAttribute($key, $value)
    {
        // First we will check for the presence of a mutator for the set operation
        // which simply lets the developers tweak the attribute as it is set on
        // the model, such as "json_encoding" an listing of data for storage.
        if ($this->hasSetMutator($key)) {
            $method = 'set' . studly_case($key) . 'Attribute';

            return $this->{$method}($value);
        }

        // If an attribute is listed as a "date", we'll convert it from a DateTime
        // instance into a form proper for storage on the database tables using
        // the connection grammar's date format. We will auto set the values.
        elseif (in_array($key, $this->getDates()) && $value) {
            $value = $this->fromDateTime($value);
        }

        // Lastly if we have a type for this key - use the field type
        // mutate method to transform the value to storage format.
        elseif ($type = $this->findAssignmentBySlug($key)->getType()) {
            $value = $type->mutate($value);
        }

        $this->attributes[$key] = $value;
    }

    /**
     * Set entry information that every record needs.
     *
     * @return $this
     */
    public function setMetaAttributes()
    {
        if (!$this->exists) {
            $createdBy = \Sentry::getUser()->id or null;

            $this->setAttribute('created_by', $createdBy);
            $this->setAttribute('updated_at', null);
            $this->setAttribute('ordering_count', $this->count('id') + 1);
        } else {
            $updatedBy = \Sentry::getUser()->id or null;

            $this->setAttribute('updated_by', $updatedBy);
            $this->setAttribute('updated_at', time());
        }

        return $this;
    }

    /**
     * Find an assignment by it's slug.
     *
     * @param $slug
     * @return mixed
     */
    public function findAssignmentBySlug($slug)
    {
        return $this
            ->getStream()
            ->assignments
            ->findBySlug($slug);
    }

    /**
     * Return a bootstrapped field type object.
     *
     * @param $slug
     * @return mixed
     */
    public function fieldType($slug)
    {
        $assignment = $this->findAssignmentBySlug($slug);

        return $assignment->field->type->setAssignment($assignment)->setEntry($this);
    }

    /**
     * Get the stream data.
     *
     * @return array
     */
    public function getStream()
    {
        if ($this->stream instanceof StreamModel) {
            return $this->stream;
        } else {
            return $this->stream = return (new StreamModel())->object($this->stream);
        }
    }

    /**
     * Return the table name with the stream prefix.
     *
     * @return string
     */
    public function getTable()
    {
        $stream = $this->getStream();

        return $stream->prefix . $stream->slug;
    }

    /**
     * Return a new collection instance.
     *
     * @param array $items
     * @return \Illuminate\Database\Eloquent\Collection|EntryCollection
     */
    public function newCollection(array $items = [])
    {
        return new EntryCollection($items);
    }

    /**
     * Return a new presenter instance.
     *
     * @param $resource
     * @return EntryPresenter|\Streams\Core\Model\Presenter\EloquentPresenter
     */
    public function newPresenter($resource)
    {
        return new EntryPresenter($resource);
    }
}
