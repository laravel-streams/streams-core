<?php namespace Streams\Core\Stream\Installer;

use Streams\Core\Support\Installer;
use Streams\Core\Addon\AddonAbstract;
use Streams\Core\Stream\Model\StreamModel;
use Streams\Core\Assignment\Installer\AssignmentInstaller;

class StreamInstaller extends Installer
{
    /**
     * Installation steps.
     *
     * @var array
     */
    protected $steps = [
        'install_stream',
        'install_assignments',
    ];

    /**
     * The stream data.
     *
     * @var array
     */
    protected $stream = [];

    /**
     * Stream field assignments.
     *
     * @var array
     */
    protected $assignments = [];

    /**
     * The stream model.
     *
     * @var null
     */
    protected $model = null;

    /**
     * Create a new StreamInstaller instance.
     */
    public function __construct(AddonAbstract $addon)
    {
        $this->addon = $addon;

        $this->streams = new StreamModel();
    }

    /**
     * Install the stream.
     *
     * @return bool
     */
    protected function installStream()
    {
        $stream = (new StreamModel())->fill($this->stream);

        if (!$stream->namespace) {
            $stream->namespace = $this->addon->getSlug();
        }

        if (!$stream->slug) {
            $slug = explode('\\', get_called_class());
            $slug = array_pop($slug);
            $slug = str_replace('StreamInstaller', '', $slug);

            $stream->slug = strtolower($slug);
        }

        if (!$stream->prefix) {
            $stream->prefix = $stream->namespace . '_';
        }

        $langPrefix = $this->addon->getType() . '.' . $stream->namespace . '::stream.' . $stream->slug;

        if (!$stream->name) {
            $stream->name = $langPrefix . '.name';
        }

        if (!$stream->description) {
            $stream->description = $langPrefix . '.description';
        }

        if (!$stream->view_options) {
            $stream->view_options = ['id', 'created_at'];
        }

        if (!$stream->title_column) {
            $stream->title_column = 'id';
        }

        if (!$stream->sort_by) {
            $stream->sort_by = 'title';
        }

        $stream->is_hidden = \StringHelper::bool($stream->is_hidden);

        $stream->is_translatable = \StringHelper::bool($stream->is_translatable);

        $stream->is_revisionable = \StringHelper::bool($stream->is_revisionable);

        $this->model = $stream;

        return $stream->save();
    }

    /**
     * Install the field assignments.
     *
     * @return bool
     */
    protected function installAssignments()
    {
        $installer = $this->newAssignmentInstaller();

        foreach ($this->assignments as $field => $assignment) {

            if (!isset($assignment['field'])) {
                $assignment['field'] = $field;
            }

            $installer->setAssignment($assignment)->install();
        }

        return true;
    }

    /**
     * Return a new AssignmentInstallerInstance.
     *
     * @return AssignmentInstaller
     */
    protected function newAssignmentInstaller()
    {
        return new AssignmentInstaller($this->addon, $this->model);
    }
}
