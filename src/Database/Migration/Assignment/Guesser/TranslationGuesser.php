<?php namespace Anomaly\Streams\Platform\Database\Migration\Assignment\Guesser;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Database\Migration\Migration;
use Anomaly\Streams\Platform\Stream\Contract\StreamRepositoryInterface;

class TranslationGuesser
{

    /**
     * The stream repository.
     *
     * @var StreamRepositoryInterface
     */
    protected $streams;

    /**
     * Create a new AssignmentInput instance.
     *
     * @param StreamRepositoryInterface $streams
     */
    public function __construct(StreamRepositoryInterface $streams)
    {
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
            array_value($stream, 'slug'),
            array_value($stream, 'namespace')
        );

        if (!$stream) {
            return;
        }

        $locale = config('app.fallback_locale');

        $assignments = $migration->getAssignments();

        foreach ($assignments as &$assignment) {
            foreach (['label', 'warning', 'instructions', 'placeholder'] as $key) {
                if (is_null(array_value($assignment, $locale . '.' . $key))) {
                    $assignment = array_add(
                        $assignment,
                        $locale . '.' . $key,
                        $addon->getNamespace(
                            'field.' . array_value($assignment, 'field') . '.' . $key . '.' . $stream->getSlug()
                        )
                    );
                }
            }
        }

        $migration->setAssignments($assignments);
    }
}
