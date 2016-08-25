<?php namespace Anomaly\Streams\Platform\Database\Migration\Command;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;
use Anomaly\Streams\Platform\Database\Migration\Migration;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class RollbackAssignments
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Command
 */
class RollbackAssignments implements SelfHandling
{

    /**
     * The migration.
     *
     * @var Migration
     */
    protected $migration;

    /**
     * Create a new RollbackAssignments instance.
     *
     * @param Migration $migration
     */
    public function __construct(Migration $migration)
    {
        $this->migration = $migration;
    }

    /**
     * Handle the command.
     *
     * @param FieldRepositoryInterface      $fields
     * @param StreamRepositoryInterface     $streams
     * @param AssignmentRepositoryInterface $assignments
     */
    public function handle(
        FieldRepositoryInterface $fields,
        StreamRepositoryInterface $streams,
        AssignmentRepositoryInterface $assignments
    ) {
        $addon  = $this->migration->getAddon();
        $stream = $this->migration->getStream();

        $namespace = array_get($stream, 'namespace', $this->migration->getNamespace());
        $slug      = array_get($stream, 'slug', $addon ? $addon->getSlug() : null);

        $stream = $streams->findBySlugAndNamespace($slug, $namespace);

        foreach ($this->migration->getAssignments() as $field => $assignment) {

            if (is_numeric($field)) {
                $field = $assignment;
            }

            if ($stream && $field = $fields->findBySlugAndNamespace($field, $namespace)) {
                if ($assignment = $assignments->findByStreamAndField($stream, $field)) {
                    $assignments->delete($assignment);
                }
            }
        }

        $assignments->cleanup();
    }
}
