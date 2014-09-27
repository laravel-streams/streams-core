<?php namespace Streams\Platform\Stream\Installer;

use Streams\Platform\Support\Installer;
use Streams\Platform\Addon\AddonAbstract;
use Streams\Platform\Stream\Model\StreamModel;
use Streams\Platform\Assignment\Installer\AssignmentsInstaller;

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
     * The model object.
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

        $this->model = $stream;

        return $stream->save();
    }

    /**
     * Uninstall a stream.
     *
     * @return bool|void
     */
    public function uninstall()
    {
        $this->fire('before_uninstall');

        (new StreamModel())->whereNamespace($this->addon->getSlug())->delete();

        $this->newAssignmentInstaller()->uninstall();

        $this->fire('after_uninstall');
    }

    /**
     * Install the field assignments.
     *
     * @return bool
     */
    protected function installAssignments()
    {
        $installer = $this->newAssignmentInstaller();

        $installer->setAssignments($this->assignments)->install();
    }

    /**
     * Return a new AssignmentsInstallerInstance.
     *
     * @return AssignmentsInstaller
     */
    protected function newAssignmentInstaller()
    {
        return new AssignmentsInstaller($this->addon, $this->model);
    }
}
