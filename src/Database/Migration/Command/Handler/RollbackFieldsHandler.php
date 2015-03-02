<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Database\Migration\Command\RollbackFields;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;
use Anomaly\Streams\Platform\Field\FieldManager;

/**
 * Class RollbackFieldsHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Command\Handler
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
     * The field manager.
     *
     * @var FieldManager
     */
    protected $manager;

    /**
     * Create a new RollbackFieldsHandler instance.
     *
     * @param FieldRepositoryInterface $fields
     * @param FieldManager             $manager
     */
    public function __construct(FieldRepositoryInterface $fields, FieldManager $manager)
    {
        $this->fields  = $fields;
        $this->manager = $manager;
    }

    /**
     * Handle the command.
     *
     * @param RollbackFields $command
     */
    public function handle(RollbackFields $command)
    {
        $migration = $command->getMigration();

        $namespace = $migration->getNamespace();

        foreach ($migration->getFields() as $slug => $field) {

            $namespace = array_get($field, 'namespace', $namespace ?: $migration->getAddonSlug());

            if ($field = $this->fields->findBySlugAndNamespace($slug, $namespace)) {
                $this->manager->delete($field);
            }
        }
    }
}
