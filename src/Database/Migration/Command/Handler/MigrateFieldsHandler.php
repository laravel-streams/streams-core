<?php namespace Anomaly\Streams\Platform\Database\Migration\Command\Handler;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Database\Migration\Command\MigrateFields;
use Anomaly\Streams\Platform\Field\FieldManager;
use Anomaly\Streams\Platform\Field\FieldNormalizer;

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
     * @var FieldNormalizer
     */
    protected $normalizer;

    /**
     * Create a new MigrateFieldsHandler instance.
     *
     * @param FieldManager    $manager
     * @param FieldNormalizer $normalizer
     */
    public function __construct(FieldManager $manager, FieldNormalizer $normalizer)
    {
        $this->manager    = $manager;
        $this->normalizer = $normalizer;
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

            if ($name = array_pull($field, 'name')) {
                $field = array_add($field, config('app.fallback_locale') . '.name', $name);
            }

            if (!array_get($field, config('app.fallback_locale') . '.name')) {
                $field = array_add(
                    $field,
                    config('app.fallback_locale') . '.name',
                    $addon ? $addon->getNamespace("field.{$slug}.name") : null
                );
            }

            $this->normalizer->normalize($field, $addon);
            $this->manager->create($field);
        }

        return true;
    }
}
