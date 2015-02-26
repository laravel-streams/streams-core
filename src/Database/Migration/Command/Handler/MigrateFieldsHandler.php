<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Database\Migration\Command\MigrateFields;
use Anomaly\Streams\Platform\Field\FieldManager;

/**
 * Class MigrateFieldsHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Command\Handler
 */
class MigrateFieldsHandler
{

    /**
     * The field manager.
     *
     * @var FieldManager
     */
    protected $manager;

    /**
     * Create a new MigrateFieldsHandler instance.
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
     * @param MigrateFields $command
     * @return bool
     */
    public function handle(MigrateFields $command)
    {
        $migration = $command->getMigration();

        $addon     = $migration->getAddon();
        $addonSlug = $migration->getAddonSlug();

        $fields    = $command->getFields() ?: $migration->getFields();
        $namespace = $command->getNamespace() ?: $migration->getNamespace();

        foreach ($fields as $slug => $field) {

            if (is_string($field)) {
                $field = ['type' => $field];
            }

            $type   = array_get($field, 'type');
            $rules  = array_get($field, 'rules', []);
            $config = array_get($field, 'config', []);
            $locked = (array_get($field, 'locked', true));

            $namespace = array_get($field, 'namespace', $namespace ?: $addonSlug);
            $name      = array_get($field, 'name', $addon ? $addon->getNamespace("field.{$slug}.name") : null);

            $this->manager->create(compact('slug', 'type', 'namespace', 'name', 'rules', 'config', 'locked'));
        }

        return true;
    }
}
