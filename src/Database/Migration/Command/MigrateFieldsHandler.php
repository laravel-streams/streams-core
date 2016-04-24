<?php namespace Anomaly\Streams\Platform\Database\Migration\Command;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Database\Migration\Command\MigrateFields;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;

/**
 * Class MigrateFieldsHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Database\Migration\Command
 */
class MigrateFieldsHandler
{

    /**
     * The field repository.
     *
     * @var FieldRepositoryInterface
     */
    protected $fields;

    /**
     * Create a new MigrateFieldsHandler instance.
     *
     * @param FieldRepositoryInterface $fields
     */
    public function __construct(FieldRepositoryInterface $fields)
    {
        $this->fields = $fields;
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
            $field['namespace'] = array_get($field, 'namespace', $namespace ?: ($addon ? $addon->getSlug() : null));

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

            /**
             * If the instructions exists in the base array
             * then move it to the translated array
             * for the default locale.
             */
            if ($instructions = array_pull($field, 'instructions')) {
                $field = array_add($field, config('app.fallback_locale') . '.instructions', $instructions);
            }

            /**
             * If the instructions is not set then make one
             * based on a standardized pattern.
             */
            if (!array_get($field, config('app.fallback_locale') . '.instructions')) {
                $field = array_add(
                    $field,
                    config('app.fallback_locale') . '.instructions',
                    $addon ? $addon->getNamespace("field.{$slug}.instructions") : null
                );
            }

            /**
             * If the placeholder exists in the base array
             * then move it to the translated array
             * for the default locale.
             */
            if ($placeholder = array_pull($field, 'placeholder')) {
                $field = array_add($field, config('app.fallback_locale') . '.placeholder', $placeholder);
            }

            /**
             * If the placeholder is not set then make one
             * based on a standardized pattern.
             */
            if (!array_get($field, config('app.fallback_locale') . '.placeholder')) {
                $field = array_add(
                    $field,
                    config('app.fallback_locale') . '.placeholder',
                    $addon ? $addon->getNamespace("field.{$slug}.placeholder") : null
                );
            }

            /**
             * If the warning exists in the base array
             * then move it to the translated array
             * for the default locale.
             */
            if ($warning = array_pull($field, 'warning')) {
                $field = array_add($field, config('app.fallback_locale') . '.warning', $warning);
            }

            /**
             * If the instructions is not set then make one
             * based on a standardized pattern.
             */
            if (!array_get($field, config('app.fallback_locale') . '.warning')) {
                $field = array_add(
                    $field,
                    config('app.fallback_locale') . '.warning',
                    $addon ? $addon->getNamespace("field.{$slug}.warning") : null
                );
            }

            // Only create if it does not exist already.
            if (!$entry = $this->fields->findBySlugAndNamespace($field['slug'], $field['namespace'])) {
                $this->fields->create($field);
            } else {
                $this->fields->save($entry->fill($field));
            }
        }

        return true;
    }
}
