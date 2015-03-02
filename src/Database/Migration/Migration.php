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
use Illuminate\Foundation\Bus\DispatchesCommands;

/**
 * Class Migration
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration
 */
abstract class Migration extends \Illuminate\Database\Migrations\Migration
{

    use DispatchesCommands;

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
     * Create fields.
     *
     * @param array       $fields
     * @param string|null $namespace
     * @return array
     */
    public function createFields(array $fields = [], $namespace = null)
    {
        return $this->dispatch(new MigrateFields($this, $fields, $namespace));
    }

    /**
     * Delete fields.
     *
     * @param array       $fields
     * @param null|string $namespace
     * @return mixed
     */
    public function deleteFields(array $fields = [], $namespace = null)
    {
        return $this->dispatch(new RollbackFields($this, $fields, $namespace));
    }

    /**
     * Create a stream.
     *
     * @param StreamInterface $stream
     * @return StreamInterface
     */
    public function createStream(StreamInterface $stream = null)
    {
        return $this->dispatch(new MigrateStream($this, $stream));
    }

    /**
     * Delete a stream.
     *
     * @param string $namespace
     * @param string $stream
     * @return mixed
     */
    public function deleteStream($namespace = null, $stream = null)
    {
        return $this->dispatch(new RollbackStream($this, $namespace, $stream));
    }

    /**
     * Assign fields to a stream.
     *
     * @param array           $fields
     * @param StreamInterface $stream
     * @return mixed
     */
    public function assignFields(array $fields = [], StreamInterface $stream = null)
    {
        return $this->dispatch(new MigrateAssignments($this, $fields, $stream));
    }

    /**
     * Unassign fields from a stream.
     *
     * @param array           $fields
     * @param StreamInterface $stream
     */
    public function unassignFields(array $fields = [], StreamInterface $stream = null)
    {
        $this->dispatch(new RollbackAssignments($this, $fields, $stream));
    }

    /**
     * Get addon from the migration name.
     *
     * @return Addon|null
     */
    public function getAddon()
    {
        return $this->dispatch(new GetAddonFromMigration($this));
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
     * Get the fields.
     *
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
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
