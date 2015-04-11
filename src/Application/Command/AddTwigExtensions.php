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
        $twig->addExtension(new MarkdownExtension(new MichelfMarkdownEngine()));
        $twig->addExtension($container->make('TwigBridge\Extension\Laravel\Form'));
        $twig->addExtension($container->make('TwigBridge\Extension\Laravel\Html'));
        $twig->addExtension($container->make('Anomaly\Streams\Platform\Ui\UiPlugin'));
        $twig->addExtension($container->make('Anomaly\Streams\Platform\Agent\AgentPlugin'));
        $twig->addExtension($container->make('Anomaly\Streams\Platform\Asset\AssetPlugin'));
        $twig->addExtension($container->make('Anomaly\Streams\Platform\Image\ImagePlugin'));
        $twig->addExtension($container->make('Anomaly\Streams\Platform\Stream\StreamPlugin'));
        $twig->addExtension($container->make('Anomaly\Streams\Platform\Message\MessagePlugin'));
        $twig->addExtension($container->make('Anomaly\Streams\Platform\Application\ApplicationPlugin'));
    }
}
