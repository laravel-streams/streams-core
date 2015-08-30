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
        return [

            // Models
            'vendor/anomaly/streams-platform/src/Entry/EntryModel.php',
            'vendor/anomaly/streams-platform/src/Field/FieldModel.php',
            'vendor/anomaly/streams-platform/src/Model/EloquentModel.php',
            'vendor/anomaly/streams-platform/src/Stream/StreamModel.php',
            'vendor/anomaly/streams-platform/src/Assignment/AssignmentModel.php',

            // Addons
            'vendor/anomaly/streams-platform/src/Addon/Theme/Theme.php',
            'vendor/anomaly/streams-platform/src/Addon/Module/Module.php',
            'vendor/anomaly/streams-platform/src/Addon/Plugin/Plugin.php',
            'vendor/anomaly/streams-platform/src/Addon/Extension/Extension.php',
            'vendor/anomaly/streams-platform/src/Addon/FieldType/FieldType.php',

            // Support
            'vendor/anomaly/streams-platform/src/Support/Parser.php',
            'vendor/anomaly/streams-platform/src/Support/String.php',
            'vendor/anomaly/streams-platform/src/Support/Observer.php',
            'vendor/anomaly/streams-platform/src/Support/Resolver.php',
            'vendor/anomaly/streams-platform/src/Support/Decorator.php',
            'vendor/anomaly/streams-platform/src/Support/Evaluator.php',
            'vendor/anomaly/streams-platform/src/Support/Evaluator.php',
            'vendor/anomaly/streams-platform/src/Support/Authorizer.php',
            'vendor/anomaly/streams-platform/src/Support/Translator.php',
            'vendor/anomaly/streams-platform/src/Support/Configurator.php'
        ];
    }
}
