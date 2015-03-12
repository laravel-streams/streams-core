<?php namespace Anomaly\Streams\Platform;

/**
 * Class StreamsCompilerProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform
 */
class StreamsCompilerProvider
{

    /**
     * Get files to compile during
     * Laravel's optimize command.
     *
     * @return array
     */
    public static function compiles()
    {
        $files = app('files')->allFiles(__DIR__);

        return array_map(
            function (\SplFileInfo $file) {
                return $file->getPathname();
            },
            $files
        );
    }
}
