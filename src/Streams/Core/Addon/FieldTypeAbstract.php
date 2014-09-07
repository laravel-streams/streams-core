<?php namespace Streams\Core\Addon;

use Streams\Core\Addon\Model\FieldTypeModel;
use Streams\Core\Addon\Presenter\FieldTypePresenter;

abstract class FieldTypeAbstract extends AddonAbstract
{
    /**
     * The database column type this field type uses.
     *
     * @var string
     */
    protected $columnType = 'string';

    /**
     * Column constraint
     *
     * @var string
     */
    protected $columnConstraint = null;

    /**
     * Field type version
     *
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * The entry model object.
     *
     * @var null
     */
    protected $entry = null;

    /**
     * The value.
     *
     * @var null
     */
    protected $value = null;

    /**
     * The field assignment model object.
     *
     * @var null
     */
    protected $assignment = null;


    /**
     * Return the form input.
     *
     * @return string
     */
    public function input()
    {
        $options = [
            'class'       => 'form-control',
            'placeholder' => $this->getPlaceholder(),
        ];

        return \Form::input('text', $this->postKey(), $this->value(), $options);
    }

    public function formName()
    {
        return $this->slug;
    }

    protected function getPlaceholder()
    {
        return null;
    }

    /**
     * Return the column name for this field type.
     *
     * @return string
     */
    public function columnName()
    {
        return $this->assignment->field->slug;
    }

    /**
     * Return placeholder text.
     *
     * @param null $default
     * @return string
     */
    public function placeholder($default = null)
    {
        if (!$placeholder = 'Test Placeholder') {
            return $default;
        }

        return $placeholder;
    }

    /**
     * Run when the field is created.
     */
    public function construct()
    {
    }

    /**
     * Run when the field is destroyed.
     */
    public function destroy()
    {
    }

    /**
     * Run when the field is assigned.
     */
    public function assigned()
    {
    }

    /**
     * Run when the field is unassigned.
     */
    public function unassigned()
    {
    }

    /**
     * Return the value for the field type.
     *
     * @param $default
     * @return null
     */
    public function value()
    {
        if (\Request::isMethod('post')) {
            return \Input::get($this->postKey());
        } elseif (isset($this->entry->{$this->entryKey()})) {
            return $this->entry->{$this->entryKey()};
        }

        return $this->defaultValue();
    }

    /**
     * Return the default value.
     *
     * @return null
     */
    protected function defaultValue()
    {
        return null;
    }

    protected function postKey()
    {
        return $this->entryKey();;
    }

    protected function entryKey()
    {
        return $this->assignment->field->slug;
    }

    /**
     * Has relation?
     *
     * @return boolean
     */
    public function hasRelation(FieldTypeAbstract $fieldType)
    {
        if (method_exists($fieldType, 'relation')) {
            $relationArray = $fieldType->relation();

            if (!is_array($relationArray) or empty($relationArray)) {
                return false;
            }

            if (!empty($relationArray['method']) and in_array(
                    $relationArray['method'],
                    $this->getValidRelationMethods()
                )
            ) {
                return true;
            }
        }
    }

    /**
     * Wrapper method for the Eloquent hasOne method.
     *
     * @param  EntryModel $related
     * @param  string     $foreignKey
     * @return Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function hasOne($related, $foreignKey = null, $localKey = null)
    {
        return [
            'method'    => __FUNCTION__,
            'arguments' => func_get_args(),
        ];
    }

    /**
     * Wrapper method for the Eloquent morphOne method.
     *
     * @param  EntryModel $related
     * @param  string     $name
     * @param  string     $type
     * @param  string     $id
     * @return Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function morphOne($related, $name, $type = null, $id = null, $localKey = null)
    {
        return [
            'method'    => __FUNCTION__,
            'arguments' => func_get_args(),
        ];
    }

    /**
     * Wrapper method for the Eloquent belongsTo() method.
     *
     * @param  EntryModel $related
     * @param  string     $foreignKey
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function belongsTo($related, $foreignKey = null)
    {
        return [
            'method'    => __FUNCTION__,
            'arguments' => func_get_args(),
        ];
    }

    /**
     * Wrapper method for the Eloquent morphTo() method.
     *
     * @param  string $name
     * @param  string $type
     * @param  string $id
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function morphTo($name = null, $type = null, $id = null)
    {
        return [
            'method'    => __FUNCTION__,
            'arguments' => func_get_args(),
        ];
    }

    /**
     * Wrapper method for the Eloquent hasMany() method.
     *
     * @param  EntryModel $related
     * @param  string     $foreignKey
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hasMany($related, $foreignKey = null)
    {
        return [
            'method'    => __FUNCTION__,
            'arguments' => func_get_args(),
        ];
    }

    /**
     * Wrapper method for the Eloquent morphMany() method.
     *
     * @param  EntryModel $related
     * @param  string     $name
     * @param  string     $type
     * @param  string     $id
     * @return Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function morphMany($related, $name, $type = null, $id = null, $localKey = null)
    {
        return [
            'method'    => __FUNCTION__,
            'arguments' => func_get_args(),
        ];
    }

    /**
     * Wrapper method for the Eloquent belongsTo() method.
     *
     * @param  EntryModel $related
     * @param  string     $table
     * @param  string     $foreignKey
     * @param  string     $otherKey
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function belongsToMany($related, $table = null, $foreignKey = null, $otherKey = null)
    {
        return [
            'method'    => __FUNCTION__,
            'arguments' => func_get_args(),
        ];
    }

    /**
     * Define a polymorphic many-to-many relationship.
     *
     * @param  string $related
     * @param  string $name
     * @param  string $table
     * @param  string $foreignKey
     * @param  string $otherKey
     * @param  bool   $inverse
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function morphToMany($related, $name, $table = null, $foreignKey = null, $otherKey = null, $inverse = false)
    {
        return [
            'method'    => __FUNCTION__,
            'arguments' => func_get_args(),
        ];
    }

    /**
     * Return the column type.
     *
     * @return string
     */
    public function getColumnType()
    {
        return $this->columnType;
    }

    /**
     * Return the column constraint.
     *
     * @return string
     */
    public function getColumnConstraint()
    {
        return $this->columnConstraint;
    }

    /**
     * Return the version.
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Get the entry object.
     *
     * @return null
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * Set the entry model object.
     *
     * @param $entry
     * @return $this
     */
    public function setEntry($entry)
    {
        $this->entry = $entry;

        return $this;
    }

    /**
     * Get the assignment object.
     *
     * @return null
     */
    public function getAssignment()
    {
        return $this->assignment;
    }

    /**
     * Set the field assignment model.
     *
     * @param $assignment
     * @return $this
     */
    public function setAssignment($assignment)
    {
        $this->assignment = $assignment;

        return $this;
    }

    /**
     * Return a new FieldTypeModel instance.
     *
     * @return null|FieldTypeModel
     */
    public function newModel()
    {
        return new FieldTypeModel();
    }

    /**
     * Return a new presenter instance.
     *
     * @param $resource
     * @return null|FieldTypePresenter
     */
    public function newPresenter($resource)
    {
        return new FieldTypePresenter($resource);
    }
}
