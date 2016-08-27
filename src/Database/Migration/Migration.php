<?php namespace Anomaly\Streams\Platform\Database\Migration;

use Anomaly\Streams\Platform\Addon\Addon;
use Illuminate\Foundation\Bus\DispatchesJobs;

abstract class Migration extends \Illuminate\Database\Migrations\Migration
{
    use DispatchesJobs;

    /**
     * The addon instance.
     *
     * This is set by the migrator when
     * an addon is being migrated.
     *
     * @var Addon
     */
    protected $addon = null;

    /**
     * The stream namespace.
     *
     * @var null|string
     */
    protected $namespace = null;

    /**
     * The migration fields.
     *
     * @var array
     */
    protected $fields = [];

    /**
     * The migration stream.
     *
     * @var array
     */
    protected $stream = [];

    /**
     * The migration assignments.
     *
     * @var array
     */
    protected $assignments = [];

    /**
     * Should the migration delete its stream when rolling back?
     *
     * @var bool
     */
    protected $delete = true;

    /**
     * Return the migration namespace.
     *
     * @return string
     */
    public function namespace()
    {
        return $this->getNamespace() ?: $this->addon->getSlug();
    }

    /**
     * Set the addon.
     *
     * @param Addon $addon
     */
    public function setAddon(Addon $addon)
    {
        $this->addon = $addon;

        return $this;
    }

    /**
     * Get the addon.
     *
     * @return Addon
     */
    public function getAddon()
    {
        return $this->addon;
    }

    /**
     * Get the namespace.
     *
     * @return null|string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Set the fields.
     *
     * @param  array $fields
     * @return $this
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Get the fields.
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Set the stream.
     *
     * @param  array $stream
     * @return $this
     */
    public function setStream(array $stream)
    {
        $this->stream = $stream;

        return $this;
    }

    /**
     * Get the stream.
     *
     * @return array
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * Set the assignments.
     *
     * @param  array $assignments
     * @return $this
     */
    public function setAssignments(array $assignments)
    {
        $this->assignments = $assignments;

        return $this;
    }

    /**
     * Get the assignments.
     *
     * @return array
     */
    public function getAssignments()
    {
        return $this->assignments;
    }

    /**
     * Migrate
     */
    public function up()
    {
    }

    /**
     * Rollback
     */
    public function down()
    {
    }
}
