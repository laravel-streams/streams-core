<?php namespace Anomaly\Streams\Platform\Database\Migration\Stream\Guesser;

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
     * Create a new StreamInput instance.
     *
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Guess the stream names.
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

        $stream = $migration->getStream();

        foreach (['name', 'description'] as $key) {
            if (is_null(array_get($stream, $locale . '.' . $key))) {
                $stream = array_add(
                    $stream,
                    $locale . '.' . $key,
                    $addon->getNamespace('stream.' . array_get($stream, 'slug') . '.' . $key)
                );
            }
        }

        $migration->setStream($stream);
    }
}
