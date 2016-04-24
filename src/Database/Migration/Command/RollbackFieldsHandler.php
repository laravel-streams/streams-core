<?php namespace Anomaly\Streams\Platform\Database\Migration\Command;

use Anomaly\Streams\Platform\Assignment\Contract\AssignmentRepositoryInterface;
use Anomaly\Streams\Platform\Database\Migration\Command\RollbackFields;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;

/**
 * Class RollbackFieldsHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Command
 */
class RollbackFieldsHandler
{

    /**
     * The field repository.
     *
     * @var FieldRepositoryInterface
     */
    protected $fields;

    /**
     * The assignment instance.
     *
     * @var AssignmentRepositoryInterface
     */
    protected $assignments;

    /**
     * Create a new RollbackFieldsHandler instance.
     *
     * @param FieldRepositoryInterface      $fields
     * @param AssignmentRepositoryInterface $assignments
     */
    public function __construct(FieldRepositoryInterface $fields, AssignmentRepositoryInterface $assignments)
    {
        $this->fields      = $fields;
        $this->assignments = $assignments;
    }

    /**
     * Handle the command.
     *
     * @param RollbackFields $command
     */
    public function handle(RollbackFields $command)
    {
        $migration = $command->getMigration();

        $addon     = $migration->getAddon();
        $namespace = $migration->getNamespace();

        foreach ($migration->getFields() as $slug => $field) {

            $namespace = array_get($field, 'namespace', $namespace ?: ($addon ? $addon->getSlug() : null));

            if ($field = $this->fields->findBySlugAndNamespace($slug, $namespace)) {
                $this->fields->delete($field);
            }
        }
    }
}
