<?php

namespace Anomaly\Streams\Platform\Database\Migration\Stream;

use Anomaly\Streams\Platform\Database\Migration\Migration;
use Anomaly\Streams\Platform\Database\Migration\Stream\Guesser\TranslationGuesser;

class StreamGuesser
{

    /**
     * Guess stream definition parameters for the migration.
     *
     * @param Migration $migration
     */
    public static function guess(Migration $migration)
    {
        self::translation($migration);
    }

    /**
     * Guess translations.
     *
     * @param \Anomaly\Streams\Platform\Database\Migration\Migration $migration
     */
    protected static function translation(Migration $migration)
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

        $locale = config('app.fallback_locale');

        $stream = $migration->getStream();

        foreach (['name', 'description'] as $key) {
            if (is_null(array_get($stream, $key . '.' . $locale))) {
                array_set(
                    $stream,
                    $key . '.' . $locale,
                    $addon->getNamespace('stream.' . array_get($stream, 'slug') . '.' . $key)
                );
            }
        }

        $migration->setStream($stream);
    }
}
