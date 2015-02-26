<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Database\Migration\Command\RollbackFields;
use Anomaly\Streams\Platform\Field\FieldManager;

/**
 * Class RollbackFieldsHandler
 *
 * @package Anomaly\Streams\Platform\Database\Migration\Command\Handler
 */
class RollbackFieldsHandler
{

    /**
     * @var FieldManager
     */
    protected $manager;

    /**
     * @param FieldManager $manager
     */
    public function __construct(FieldManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param RollbackFields $command
     *
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