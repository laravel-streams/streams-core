<?php namespace Anomaly\Streams\Platform\Database\Migration\Assignment\Guesser;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Database\Migration\Migration;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;
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
     * The stream repository.
     *
     * @var StreamRepositoryInterface
     */
    protected $streams;

    /**
     * Create a new AssignmentInput instance.
     *
     * @param Repository                $config
     * @param StreamRepositoryInterface $streams
     */
    public function __construct(Repository $config, StreamRepositoryInterface $streams)
    {
        $this->config  = $config;
        $this->streams = $streams;
    }

    /**
     * Guess the assignment names.
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

        $stream = $migration->getStream();

        $stream = $this->streams->findBySlugAndNamespace(
            array_get($stream, 'slug'),
            array_get($stream, 'namespace')
        );

        if (!$stream) {
            return;
        }

        $locale = $this->config->get('app.fallback_locale');

        $assignments = $migration->getAssignments();

        foreach ($assignments as &$assignment) {
            foreach (['label', 'warning', 'instructions', 'placeholder'] as $key) {
                if (is_null(array_get($assignment, $locale . '.' . $key))) {
                    $assignment = array_add(
                        $assignment,
                        $locale . '.' . $key,
                        $addon->getNamespace(
                            'field.' . array_get($assignment, 'field') . '.' . $key . '.' . $stream->getSlug()
                        )
                    );
                }
            }
        }

        $migration->setAssignments($assignments);
    }
}
