<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Addon\Addon;
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

        /* @var Addon $addon */
        $addon     = $migration->getAddon();
        $fields    = $migration->getFields();
        $namespace = $migration->getNamespace();

        foreach ($fields as $slug => $field) {

            if (is_string($field)) {
                $field = ['type' => $field];
            }

            $field['slug']      = $slug;
            $field['type']      = array_get($field, 'type');
            $field['namespace'] = array_get($field, 'namespace', $namespace ?: $addon ? $addon->getSlug() : null);

            /**
             * If the name exists in the base array
             * then move it to the translated array
             * for the default locale.
             */
            if ($name = array_pull($field, 'name')) {
                $field = array_add($field, config('app.fallback_locale') . '.name', $name);
            }

            /**
             * If the name is not set then make one
             * based on a standardized pattern.
             */
            if (!array_get($field, config('app.fallback_locale') . '.name')) {
                $field = array_add(
                    $field,
                    config('app.fallback_locale') . '.name',
                    $addon ? $addon->getNamespace("field.{$slug}.name") : null
                );
            }

            $this->manager->create($field);
        }

        return true;
    }
}
