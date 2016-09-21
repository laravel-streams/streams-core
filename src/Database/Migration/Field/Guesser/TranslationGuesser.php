<?php namespace Anomaly\Streams\Platform\Database\Migration\Field\Guesser;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Database\Migration\Migration;
use Illuminate\Contracts\Config\Repository;

class TranslationGuesser
{

    /**
     * The config repository.
     *
     * @var Repository
     */
    protected $config;

    /**
     * Create a new FieldInput instance.
     *
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Guess the field names.
     *
     * @param Migration $migration
     */
    public function guess(Migration $migration)
    {

        /**
         * If we don't have any addon then
         * we can't automate anything.
         *
         * @var Addon $addon
         */
        if (!$addon = $migration->getAddon()) {
            return;
        }

        $locale = $this->config->get('app.fallback_locale');

        $fields = $migration->getFields();

        foreach ($fields as &$field) {
            foreach (['name', 'warning', 'instructions', 'placeholder'] as $key) {
                if (is_null(array_get($field, $locale . '.' . $key))) {
                    $field = array_add(
                        $field,
                        $locale . '.' . $key,
                        $addon->getNamespace('field.' . array_get($field, 'slug') . '.' . $key)
                    );
                }
            }
        }

        $migration->setFields($fields);
    }
}
