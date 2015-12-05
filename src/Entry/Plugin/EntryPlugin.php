<?php namespace Anomaly\Streams\Platform\Entry\Plugin;

use Anomaly\Streams\Platform\Addon\Plugin\Plugin;
use Anomaly\Streams\Platform\Entry\Plugin\Command\GetEntryBuilder;

/**
 * Class EntryPlugin
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Entry\Plugin
 */
class EntryPlugin extends Plugin
{

    /**
     * Get the plugin functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'entry',
                function ($namespace, $stream) {
                    return $this->dispatch(new GetEntryBuilder($namespace, $stream, 'first'));
                }
            ),
            new \Twig_SimpleFunction(
                'entries',
                function ($namespace, $stream) {
                    return $this->dispatch(new GetEntryBuilder($namespace, $stream, 'get'));
                }
            )
        ];
    }
}
