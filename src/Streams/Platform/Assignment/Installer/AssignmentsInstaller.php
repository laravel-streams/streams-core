<?php namespace Streams\Platform\Assignment\Installer;

use Streams\Platform\Support\Installer;
use Streams\Platform\Addon\AddonAbstract;
use Streams\Platform\Field\Model\FieldModel;
use Streams\Platform\Stream\Model\StreamModel;
use Streams\Platform\Assignment\Model\AssignmentModel;

class AssignmentsInstaller extends Installer
{
    /**
     * The assignments data.
     *
     * @var array
     */
    protected $assignments = [];

    /**
     * The addon object.
     *
     * @var \Streams\Platform\Addon\AddonAbstract
     */
    protected $addon;

    /**
     * Create a new AssignmentsInstaller instance.
     */
    public function __construct(AddonAbstract $addon, StreamModel $stream)
    {
        $this->addon  = $addon;
        $this->stream = $stream;

        $this->fields      = new FieldModel();
        $this->assignments = new AssignmentModel();
    }

    /**
     * Install the assignments.
     *
     * @return bool|void
     */
    public function install()
    {
        $this->fire('before_install');

        foreach ($this->assignments as $fieldSlug => $assignment) {
            $this->installAssignment($fieldSlug, $assignment);
        }

        $this->fire('after_install');
    }

    /**
     * Install an assignment.
     *
     * @param $fieldSlug
     * @param $assignment
     */
    protected function installAssignment($fieldSlug, $assignment)
    {
        $assignment = (new AssignmentModel())->fill($assignment);

        $field = $this->fields->findBySlugAndNamespace($fieldSlug, $this->stream->namespace);

        $langPrefix = $this->addon->getType() . '.' . $field->namespace . '::field.' . $field->slug;

        if (!$assignment->sort_order) {
            $assignment->sort_order = 0;
        }

        $assignment->stream_id = $this->stream->getKey();
        $assignment->field_id  = $field->getKey();

        if (!$assignment->name) {
            $assignment->name = $field->name;
        }

        if (!$assignment->instructions) {
            $assignment->instructions = $langPrefix . '.instructions';
        }

        $assignment->is_unique       = boolean($assignment->is_unique);
        $assignment->is_required     = boolean($assignment->is_required);
        $assignment->is_translatable = boolean($assignment->is_translatable);
        $assignment->is_revisionable = boolean($assignment->is_revisionable);

        $assignment->save();
    }

    /**
     * Set the assignments.
     *
     * @param $assignments
     * @return $this
     */
    public function setAssignments($assignments)
    {
        $this->assignments = $assignments;

        return $this;
    }
}
