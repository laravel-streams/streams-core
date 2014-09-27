<?php namespace Streams\Platform\Assignment\Installer;

use Streams\Platform\Support\Installer;
use Streams\Platform\Addon\AddonAbstract;
use Streams\Platform\Field\Model\FieldModel;
use Streams\Platform\Stream\Model\StreamModel;
use Streams\Platform\Assignment\Model\AssignmentModel;

class AssignmentInstaller extends Installer
{
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
     * Create a new AssignmentsInstaller instance.
     *
     * @param AddonAbstract $addon
     */
    public function __construct(AddonAbstract $addon)
    {
        $this->addon  = $addon;
    }

    /**
     * Install the assignments.
     *
     * @return bool|void
     */
    public function install()
    {
        $this->fire('before_install');

        $this->installAssignment();

        $this->fire('after_install');
    }

    /**
     * Uninstall assignments.
     *
     * @return bool|void
     */
    public function uninstall()
    {
        $streams = array_merge((new StreamModel())->all()->lists('id'), [0]);

        (new AssignmentModel())->whereNotIn('stream_id', $streams)->delete();
    }

    /**
     * Install an assignment.
     *
     * @param $fieldSlug
     * @param $assignment
     */
    protected function installAssignment()
    {
        $assignment = (new AssignmentModel())->fill($this->assignment);

        $field = (new FieldModel())->findBySlugAndNamespace($assignment->field, $this->stream->namespace);

        unset($assignment->field);

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
     * Set the assignment.
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
     * Set the stream.
     *
     * @param $stream
     * @return $this
     */
    public function setStream($stream)
    {
        $this->stream = $stream;

        return $this;
    }
}
