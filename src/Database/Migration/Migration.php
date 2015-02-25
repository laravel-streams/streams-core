<?php namespace Anomaly\Streams\Platform\Database\Migration;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Database\Migration\Command\GetAddonFromMigration;
use Anomaly\Streams\Platform\Database\Migration\Command\MigrateAssignments;
use Anomaly\Streams\Platform\Database\Migration\Command\MigrateFields;
use Anomaly\Streams\Platform\Database\Migration\Command\MigrateStream;
use Anomaly\Streams\Platform\Database\Migration\Command\RollbackAssignments;
use Anomaly\Streams\Platform\Database\Migration\Command\RollbackFields;
use Anomaly\Streams\Platform\Database\Migration\Command\RollbackStream;
use Anomaly\Streams\Platform\Stream\Contract\StreamInterface;
use Anomaly\Streams\Platform\Stream\StreamModel;
use Illuminate\Database\Migrations\Migration as BaseMigration;
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class Migration
 *
 * @package Anomaly\Streams\Platform\Database\Migration
 */
abstract class Migration extends BaseMigration
{
    use DispatchesCommands;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var array
     */
    protected $stream = [];

    /**
     * @var array
     */
    protected $assignments = [];

    /**
     * @param array       $fields
     * @param string|null $namespace
     *
     * @return array
     */
    public function createFields(array $fields = [], $namespace = null)
    {
        return $this->dispatch(new MigrateFields($this, $fields, $namespace));
    }

    /**
     * @param array $fields
     * @param null|string  $namespace
     *
     * @return mixed
     */
    public function deleteFields(array $fields = [], $namespace = null)
    {
        return $this->dispatch(new RollbackFields($this, $fields, $namespace));
    }

    /**
     * @param StreamInterface $stream
     *
     * @return StreamInterface
     */
    public function createStream(StreamInterface $stream = null)
    {
        return $this->dispatch(new MigrateStream($this, $stream));
    }

    /**
     * @param string $namespace
     * @param string $stream
     *
     * @return mixed
     */
    public function deleteStream($namespace = null, $stream = null)
    {
        return $this->dispatch(new RollbackStream($this, $namespace, $stream));
    }

    /**
     * @param array           $fields
     * @param StreamInterface $stream
     *
     * @return mixed
     */
    public function assignFields(array $fields = [], StreamInterface $stream = null)
    {
        return $this->dispatch(new MigrateAssignments($this, $fields, $stream));
    }

    /**
     * @param array           $fields
     * @param StreamInterface $stream
     */
    public function unassignFields(array $fields = [], StreamInterface $stream = null)
    {
        $this->dispatch(new RollbackAssignments($this, $fields, $stream));
    }

    /**
     * @return null|string
     */
    public function getAddonSlug()
    {
        return $this->getAddon() ? $this->getAddon()->getSlug() : null;
    }

    /**
     * Get addon from the migration name
     *
     * @return Addon|null
     */
    public function getAddon()
    {
        return $this->dispatch(new GetAddonFromMigration($this));
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace ?: $this->getAddonSlug();
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @return array
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
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