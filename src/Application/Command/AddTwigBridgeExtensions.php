<?php namespace Anomaly\Streams\Platform\Application\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Container\Container;
use TwigBridge\Bridge;

/**
 * Class AddTwigBridgeExtensions
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application\Command
 */
class AddTwigBridgeExtensions implements SelfHandling
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
    }
}
