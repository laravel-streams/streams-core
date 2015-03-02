<?php namespace Anomaly\Streams\Platform\Application\Command;

use Aptoma\Twig\Extension\MarkdownEngine\MichelfMarkdownEngine;
use Aptoma\Twig\Extension\MarkdownExtension;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Container\Container;
use TwigBridge\Bridge;

/**
 * Class AddTwigExtensions
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application\Command
 */
class AddTwigExtensions implements SelfHandling
{

    /**
     * Handle the command.
     *
     * @param Bridge    $twig
     * @param Container $container
     */
    public function handle(Bridge $twig, Container $container)
    {
        /**
         * These are included in the
         * package but disabled by default.
         */
        $twig->addExtension($container->make('TwigBridge\Extension\Laravel\Form'));
        $twig->addExtension($container->make('TwigBridge\Extension\Laravel\Html'));

        // Markdown support
        $twig->addExtension(new MarkdownExtension(new MichelfMarkdownEngine()));

        // Application plugin
        $twig->addExtension($container->make('Anomaly\Streams\Platform\Application\ApplicationPlugin'));
    }
}
