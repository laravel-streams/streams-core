<?php namespace Anomaly\Streams\Platform\Application\Command;

use Aptoma\Twig\Extension\MarkdownEngine\MichelfMarkdownEngine;
use Aptoma\Twig\Extension\MarkdownExtension;
use Illuminate\Contracts\Bus\SelfHandling;
use TwigBridge\Bridge;

/**
 * Class AddMarkdownExtension
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Application\Command
 */
class AddMarkdownExtension implements SelfHandling
{

    /**
     * Handle the command.
     */
    public function handle(Bridge $twig)
    {
        $twig->addExtension(new MarkdownExtension(new MichelfMarkdownEngine()));
    }
}
