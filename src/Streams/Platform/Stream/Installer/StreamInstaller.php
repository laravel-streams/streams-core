<?php namespace Streams\Platform\Stream\Installer;

use Streams\Platform\Support\Installer;
use Streams\Platform\Addon\AddonAbstract;
use Streams\Platform\Stream\Model\StreamModel;
use Streams\Platform\Assignment\Installer\AssignmentInstaller;

class StreamInstaller extends Installer
{
    /**
     * The stream information.
     *
     * @var array
     */
    protected $stream = [
        'is_translatable' => 0,
        'is_revisionable' => 0,
    ];

    /**
     * Stream field assignments.
     *
     * @var array
     */
    protected $assignments = [];

    /**
     * Create a new StreamInstaller instance.
     */
    public function __construct(AddonAbstract $addon)
    {
        $this->addon = $addon;

        $this->assignmentInstaller = $this->newAssignmentInstaller();
    }

    /**
     * Install the stream.
     *
     * @return bool
     */
    public function install()
    {
        $this->fire('before_install');

        $this->installStream();
        $this->installAssignments();

        $this->fire('after_install');
    }

    /**
     * Uninstall a stream.
     *
     * @return bool|void
     */
    public function uninstall()
    {
        $this->fire('before_uninstall');

        $slug = explode('\\', get_called_class());
        $slug = array_pop($slug);
        $slug = str_replace('StreamInstaller', '', $slug);
        $slug = strtolower($slug);

        (new StreamModel())->findBySlugAndNamespace($slug, $this->addon->getSlug())->delete();

        $this->newAssignmentInstaller()->uninstall();

        $this->fire('after_uninstall');
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

        $stream->save();

        $this->assignmentInstaller->setStream($stream);
    }

    /**
     * Install the field assignments.
     *
     * @return bool
     */
    protected function installAssignments()
    {
        foreach ($this->assignments as $field => $assignment) {
            if (!isset($assignment['field'])) {
                $assignment['field'] = $field;
            }

            $this->assignmentInstaller->setAssignment($assignment)->install();
        }
    }

    /**
     * Return a new AssignmentInstallerInstance.
     *
     * @return AssignmentInstaller
     */
    protected function newAssignmentInstaller()
    {
        return new AssignmentInstaller($this->addon);
    }
}
