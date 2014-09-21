<?php namespace Streams\Platform\Assignment\Installer;

use Streams\Platform\Support\Installer;
use Streams\Platform\Addon\AddonAbstract;
use Streams\Platform\Field\Model\FieldModel;
use Streams\Platform\Stream\Model\StreamModel;
use Streams\Platform\Assignment\Model\AssignmentModel;

class AssignmentInstaller extends Installer
{
    /**
     * The installation steps.
     *
     * @var array
     */
    protected $steps = [
        'install_assignment',
    ];

    /**
     * The assignment data.
     *
     * @var array
     */
    protected $assignment = [];

    /**
     * The addon object.
     *
     * @var \Streams\Platform\Addon\AddonAbstract
     */
    protected $addon;

    /**
     * The stream object.
     *
     * @var \Streams\Model\StreamModel
     */
    protected $stream;

    /**
     * Create a new FieldInstaller instance.
     */
    public function __construct(AddonAbstract $addon, StreamModel $stream)
    {
        $this->addon  = $addon;
        $this->stream = $stream;

        $this->fields      = new FieldModel();
        $this->assignments = new AssignmentModel();
    }

    /**
     * Install the assignment.
     *
     * @return bool
     */
    protected function installAssignment()
    {
        $assignment = (new AssignmentModel())->fill($this->assignment);

        $field = $this->fields->findBySlugAndNamespace($assignment->field, $this->stream->namespace);

        unset($assignment->field);

        $langPrefix = $this->addon->getType() . '.' . $field->namespace . '::field.' . $field->slug;

        if (!$assignment->sort_order) {
            $assignment->sort_order = 0;
        }

        $assignment->stream_id = $this->stream->getKey();
        $assignment->field_id  = $field->getKey();

        if (!$assignment->name) {
            $assignment->name = $field->getResource()->name;
        }

        if (!$assignment->instructions) {
            $assignment->instructions = $langPrefix . '.instructions';
        }

        $assignment->is_required     = \StringHelper::bool($assignment->is_required);
        $assignment->is_unique       = \StringHelper::bool($assignment->is_unique);
        $assignment->is_translatable = \StringHelper::bool($assignment->is_translatable);
        $assignment->is_revisionable = \StringHelper::bool($assignment->is_revisionable);

        return $assignment->save();
    }

    /**
     * Set the assignment data.
     *
     * @param $assignment
     * @return $this
     */
    public function setAssignment($assignment)
    {
        $this->assignment = $assignment;

        return $this;
    }
}
