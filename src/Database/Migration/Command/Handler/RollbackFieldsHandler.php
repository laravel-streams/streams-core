<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Database\Migration\Command\RollbackFields;
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
     * The field manager.
     *
     * @var FieldManager
     */
    protected $manager;

    /**
     * Create a new RollbackFieldsHandler instance.
     *
     * @param FieldManager $manager
     */
    public function __construct(FieldManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Handle the command.
     *
     * @param RollbackFields $command
     * @return bool
     */
    public function handle(RollbackFields $command)
    {
        $migration = $command->getMigration();
        $namespace = $command->getNamespace() ?: $migration->getNamespace();

        foreach ($command->getFields() as $slug => $field) {

            $namespace = array_get($field, 'namespace', $namespace ?: $migration->getAddonSlug());

            $this->manager->delete($namespace, $slug);
        }

        return true;
    }
}
