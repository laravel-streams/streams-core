<?php namespace Anomaly\Streams\Platform\Database\Migration\Command;

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;

class RollbackFields
{

    /**
     * The migration.
     *
     * @var Migration
     */
    protected $migration;

    /**
     * Create a new RollbackFields instance.
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
     * @param AssignmentRepositoryInterface $assignments
     */
    public function handle(FieldRepositoryInterface $fields, AssignmentRepositoryInterface $assignments)
    {
        $addon     = $this->migration->getAddon();
        $namespace = $this->migration->getNamespace();

        foreach ($this->migration->getFields() as $slug => $field) {
            $namespace = array_get($field, 'namespace', $namespace ?: ($addon ? $addon->getSlug() : null));

            if ($field = $this->fields->findBySlugAndNamespace($slug, $namespace)) {
                $this->fields->delete($field);
            }
        }
    }
}
