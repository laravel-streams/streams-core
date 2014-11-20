<?php namespace Anomaly\Streams\Platform\Entry;

use Anomaly\Streams\Addon\Module\Users\User\Contract\UserInterface;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentInterface;
use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\Field\Contract\FieldInterface;
use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Stream\StreamModel;

/**
 * Class EntryModel
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry
 */
class EntryModel extends EloquentModel implements EntryInterface
{

    /**
     * The compiled stream data.
     *
     * @var array
     */
    protected $stream = [];

    /**
     * Create a new EntryModel instance.
     */
    public function __construct($attributes = [])
    {
        parent::__construct($attributes);

        $this->stream = (new StreamModel())->make($this->stream);

        $this->stream->parent = $this;
    }

    /**
     * Set entry information that every record needs.
     *
     * @return EntryInterface
     */
    public function touchMeta()
    {
        $userId = null;

        if ($user = app('auth')->check() and $user instanceof UserInterface) {

            $userId = $user->getId();
        }

        if (!$this->exists) {

            $this->setAttribute('created_at', time());
            $this->setAttribute('created_by', $userId);
            $this->setAttribute('updated_at', null);
            $this->setAttribute('ordering_count', $this->count('id') + 1);
        } else {

            $this->setAttribute('updated_at', time());
            $this->setAttribute('updated_by', $userId);
        }

        return $this;
    }

    /**
     * Get an attribute value by a field slug.
     *
     * This is a pretty automated process. Let
     * the accessor method overriding Eloquent
     * take care of this whole ordeal.
     *
     * @param $fieldSlug
     * @return mixed
     */
    public function getFieldValue($fieldSlug)
    {
        return $this->{$fieldSlug};
    }

    /**
     * Set a given attribute on the model.
     *
     * Override the behavior here to give
     * the field types a chance to modify things.
     *
     * @param  string $key
     * @param  mixed  $value
     * @param bool    $mutate
     * @return void
     */
    public function setAttribute($key, $value, $mutate = true)
    {
        /**
         * If we have a field type for this key use
         * it's setAttribute method to set the value.
         */
        if ($mutate and $field = $this->getField($key)) {

            $type = $field->getType();

            if ($type->setAttribute($this->attributes, $value) === true) {

                return;
            }

            $value = $type->mutate($value);
        }

        parent::setAttribute($key, $value);
    }

    /**
     * Get a given attribute on the model.
     *
     * Override the behavior here to give
     * the field types a chance to modify things.
     *
     * @param  string $key
     * @param bool    $mutate
     * @return void
     */
    public function getAttribute($key, $mutate = true)
    {
        $value = parent::getAttribute($key);

        /**
         * If we have a field type for this key use
         * it's unmutate method to modify the value.
         */
        if ($mutate and $field = $this->getField($key)) {

            $type = $field->getType();

            return $type->unmutate($value);
        }

        return $value;
    }

    /**
     * Get the stream.
     *
     * @return StreamInterface
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * Get an entry field.
     *
     * @param $slug
     * @return FieldInterface|null
     */
    public function getField($slug)
    {
        $assignment = $this->getAssignment($slug);

        if (!$assignment instanceof AssignmentInterface) {

            return null;
        }

        return $assignment->getField();
    }

    /**
     * Get an assignment by field slug.
     *
     * @param $fieldSlug
     * @return AssignmentInterface
     */
    public function getAssignment($fieldSlug)
    {
        $stream = $this->getStream();

        $assignments = $stream->getAssignments();

        return $assignments->findByFieldSlug($fieldSlug);
    }
}
