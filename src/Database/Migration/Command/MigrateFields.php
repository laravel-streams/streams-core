<?php namespace Anomaly\Streams\Platform\Database\Migration\Command;

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Anomaly\Streams\Platform\Field\Contract\FieldRepositoryInterface;

/**
 * Class MigrateFields
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 */
class MigrateFields
{

    /**
     * The migration.
     *
     * @var Migration
     */
    protected $migration;

    /**
     * Create a new MigrateFields instance.
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
     * @param  MigrateFields $command
     * @return bool
     */
    public function handle(FieldRepositoryInterface $fields)
    {
        /* @var Addon $addon */
        $addon     = $this->migration->getAddon();
        $fields    = $this->migration->getFields();
        $namespace = $this->migration->getNamespace();

        foreach ($fields as $slug => $field) {
            if (is_string($field)) {
                $field = ['type' => $field];
            }

            $field['slug']      = $slug;
            $field['type']      = array_get($field, 'type');
            $field['namespace'] = array_get($field, 'namespace', $namespace ?: ($addon ? $addon->getSlug() : null));

            /*
             * If the name exists in the base array
             * then move it to the translated array
             * for the default locale.
             */
            if ($name = array_pull($field, 'name')) {
                $field = array_add($field, config('app.fallback_locale') . '.name', $name);
            }

            /*
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

            /*
             * If the instructions exists in the base array
             * then move it to the translated array
             * for the default locale.
             */
            if ($instructions = array_pull($field, 'instructions')) {
                $field = array_add($field, config('app.fallback_locale') . '.instructions', $instructions);
            }

            /*
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

            /*
             * If the placeholder exists in the base array
             * then move it to the translated array
             * for the default locale.
             */
            if ($placeholder = array_pull($field, 'placeholder')) {
                $field = array_add($field, config('app.fallback_locale') . '.placeholder', $placeholder);
            }

            /*
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

            /*
             * If the warning exists in the base array
             * then move it to the translated array
             * for the default locale.
             */
            if ($warning = array_pull($field, 'warning')) {
                $field = array_add($field, config('app.fallback_locale') . '.warning', $warning);
            }

            /*
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
            if (!$entry = $fields->findBySlugAndNamespace($field['slug'], $field['namespace'])) {
                $fields->create($field);
            } else {
                $fields->save($entry->fill($field));
            }
        }

        return true;
    }
}
