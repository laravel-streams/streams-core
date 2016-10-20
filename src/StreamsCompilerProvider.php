<?php namespace Anomaly\Streams\Platform;

/**
 * Class StreamsCompilerProvider
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
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
            'vendor/anomaly/streams-platform/src/Stream/StreamModel.php',
            'vendor/anomaly/streams-platform/src/Assignment/AssignmentModel.php',

            // Addons
            'vendor/anomaly/streams-platform/src/Addon/Theme/Theme.php',
            'vendor/anomaly/streams-platform/src/Addon/Module/Module.php',
            'vendor/anomaly/streams-platform/src/Addon/Plugin/Plugin.php',
            'vendor/anomaly/streams-platform/src/Addon/Extension/Extension.php',
            'vendor/anomaly/streams-platform/src/Addon/FieldType/FieldType.php',

            // Addon Collections
            'vendor/anomaly/streams-platform/src/Addon/Theme/ThemeCollection.php',
            'vendor/anomaly/streams-platform/src/Addon/Module/ModuleCollection.php',
            'vendor/anomaly/streams-platform/src/Addon/Plugin/PluginCollection.php',
            'vendor/anomaly/streams-platform/src/Addon/Extension/ExtensionCollection.php',
            'vendor/anomaly/streams-platform/src/Addon/FieldType/FieldTypeCollection.php',

            // Support
            'vendor/anomaly/streams-platform/src/Support/Parser.php',
            'vendor/anomaly/streams-platform/src/Support/Template.php',
            'vendor/anomaly/streams-platform/src/Support/Observer.php',
            'vendor/anomaly/streams-platform/src/Support/Resolver.php',
            'vendor/anomaly/streams-platform/src/Support/Decorator.php',
            'vendor/anomaly/streams-platform/src/Support/Evaluator.php',
            'vendor/anomaly/streams-platform/src/Support/Authorizer.php',
            'vendor/anomaly/streams-platform/src/Support/Translator.php',
            'vendor/anomaly/streams-platform/src/Support/Configurator.php',

            // Miscellaneous
            'vendor/anomaly/streams-platform/src/Http/Middleware/MiddlewareCollection.php',
            'vendor/anomaly/streams-platform/src/Addon/Extension/ExtensionModel.php',
            'vendor/anomaly/streams-platform/src/Addon/Module/ModuleModel.php',
            'vendor/anomaly/streams-platform/src/View/ViewMobileOverrides.php',
            'vendor/anomaly/streams-platform/src/Model/EloquentPresenter.php',
            'vendor/anomaly/streams-platform/src/Addon/AddonIntegrator.php',
            'vendor/anomaly/streams-platform/src/Entry/EntryPresenter.php',
            'vendor/anomaly/streams-platform/src/Addon/AddonManager.php',
            'vendor/anomaly/streams-platform/src/View/ViewOverrides.php',
        ];
    }
}
