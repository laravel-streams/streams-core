<?php namespace Anomaly\Streams\Platform\Traits;

use Anomaly\Streams\Platform\Model\Revision;

trait RevisionableTrait
{

    /**
     * Original data.
     *
     * @var null
     */
    protected $originalData = null;

    /**
     * Updated data.
     *
     * @var null
     */
    private $updatedData = null;

    /**
     * Updating flag.
     *
     * @var null
     */
    protected $updating = null;

    /**
     * Exclude these attribtues.
     *
     * @var array
     */
    protected $exclude = [];

    /**
     * Include these attributes.
     *
     * @var array
     */
    protected $include = [];

    /**
     * The array of updated data.
     *
     * @var array
     */
    protected $dirtyData = [];

    /**
     * Observe model events to save revisions
     * automatically every time.
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(
            function ($model) {
                $model->preSave();
            }
        );

        static::saved(
            function ($model) {
                $model->postSave();
            }
        );

        static::deleted(
            function ($model) {
                $model->preSave();
                $model->postDelete();
            }
        );
    }

    /**
     * Ran before the model is saved.
     */
    public function preSave()
    {
        if (isset($this->revisionable) and $this->revisionable) {
            $this->originalData = $this->original;
            $this->updatedData  = $this->attributes;

            foreach ($this->updatedData as $key => $val) {
                if (gettype($val) == 'object') {
                    unset($this->originalData[$key]);
                    unset($this->updatedData[$key]);
                }
            }

            $this->exclude = isset($this->excludeRevisionOf) ?
                $this->excludeRevisionOf + $this->exclude
                : $this->exclude;

            $this->include = isset($this->keepRevisionOf) ?
                $this->keepRevisionOf + $this->include
                : $this->include;

            unset($this->attributes['excludeRevisionOf']);
            unset($this->attributes['keepRevisionOf']);

            $this->dirtyData = $this->getDirty();
            $this->updating  = $this->exists;
        }
    }


    /**
     * Ran after a model is successfully saved.
     */
    public function postSave()
    {
        if (isset($this->revisionable) and $this->revisionable and $this->updating) {
            $changes = $this->changedRevisionableFields();

            $revisions = [];

            foreach ($changes as $key => $change) {
                $revisions[] = [
                    'revisionable_type' => get_class($this),
                    'revisionable_id'   => $this->getKey(),
                    'key'               => $key,
                    'old_value'         => array_get($this->originalData, $key),
                    'new_value'         => $this->updatedData[$key],
                    'user_id'           => $this->getUserId(),
                    'created_at'        => new \DateTime(),
                    'updated_at'        => new \DateTime(),
                ];
            }

            if (count($revisions) > 0) {
                $revision = new Revision();
                \DB::table($revision->getTable())->insert($revisions);
            }
        }
    }

    /**
     * If soft deletes are enabled, store the deleted time
     */
    public function postDelete()
    {
        if (isset($this->revisionable) and $this->revisionable
            and $this->isSoftDelete()
            and $this->isRevisionable('deleted_at')
        ) {
            $revisions[] = [
                'revisionable_type' => get_class($this),
                'revisionable_id'   => $this->getKey(),
                'key'               => 'deleted_at',
                'old_value'         => null,
                'new_value'         => $this->deleted_at,
                'user_id'           => $this->getUserId(),
                'created_at'        => new \DateTime(),
                'updated_at'        => new \DateTime(),
            ];

            $revision = new \Venturecraft\Revisionable\Revision;
            \DB::table($revision->getTable())->insert($revisions);
        }
    }

    /**
     * Attempt to find the user id of the currently logged in user
     * Supports Cartalyst Sentry/Sentinel based authentication, as well as stock Auth
     **/
    private function getUserId()
    {
        try {
            if (class_exists($class = '\Cartalyst\Sentry\Facades\Laravel\Sentry')
                || class_exists($class = '\Cartalyst\Sentinel\Laravel\Facades\Sentinel')
            ) {
                return ($class::check()) ? $class::getUser()->id : null;
            } elseif (\Auth::check()) {
                return \Auth::user()->getAuthIdentifier();
            }
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }

    /**
     * Get all of the changes that have been made, that are also supposed
     * to have their changes recorded
     *
     * @return array fields with new data, that should be recorded
     */
    private function changedRevisionableFields()
    {
        $changes = [];

        foreach ($this->dirtyData as $key => $value) {
            if ($this->isRevisionable($key) and !is_array($value)) {
                if (!isset($this->originalData[$key]) || $this->originalData[$key] != $this->updatedData[$key]) {
                    $changes[$key] = $value;
                }
            } else {
                unset($this->updatedData[$key]);
                unset($this->originalData[$key]);
            }
        }

        return $changes;
    }

    /**
     * Check if the attribute should have revisions stored.
     *
     * @param $attribute
     * @return bool
     */
    private function isRevisionable($attribute)
    {
        if (isset($this->include) and in_array($attribute, $this->include)) {
            return true;
        }
        if (isset($this->exclude) and in_array($attribute, $this->exclude)) {
            return false;
        }

        return empty($this->include);
    }

    /**
     * Check if soft deletes are enabled on this model.
     *
     * @return bool
     */
    private function isSoftDelete()
    {
        if (isset($this->forceDeleting)) {
            return !$this->forceDeleting;
        }

        if (isset($this->softDelete)) {
            return $this->softDelete;
        }

        return false;
    }

    /**
     * Get revision formatted fields.
     *
     * @return mixed
     */
    public function getRevisionFormattedFields()
    {
        return $this->revisionFormattedFields;
    }

    /**
     * Get revision formatted field names.
     *
     * @return mixed
     */
    public function getRevisionFormattedFieldNames()
    {
        return $this->revisionFormattedFieldNames;
    }

    /**
     * Get the revision "null" string.
     *
     * @return string
     */
    public function getRevisionNullString()
    {
        return isset($this->revisionNullString) ? $this->revisionNullString : 'nothing';
    }

    /**
     * Get the revision "unknown" string.
     *
     * @return string
     */
    public function getRevisionUnknownString()
    {
        return isset($this->revisionUnknownString) ? $this->revisionUnknownString : 'unknown';
    }

    /**
     * Temporarily disable a revisionable field.
     *
     * @param $field
     */
    public function disableRevisionField($field)
    {
        if (!isset($this->excludeRevisionOf)) {
            $this->excludeRevisionOf = [];
        }

        if (is_array($field)) {
            foreach ($field as $one_field) {
                $this->disableRevisionField($one_field);
            }
        } else {
            $donts                   = $this->excludeRevisionOf;
            $donts[]                 = $field;
            $this->excludeRevisionOf = $donts;
            unset($donts);
        }
    }

    /**
     * Revision history relationship.
     *
     * @return mixed
     */
    public function revisionHistory()
    {
        return $this->morphMany('\Anomaly\Streams\Platform\Model\Revision', 'revisionable');
    }
}
