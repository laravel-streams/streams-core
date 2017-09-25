<?php namespace Anomaly\Streams\Platform\View\Twig\Console;

use Illuminate\Console\Command;

/**
 * Class TwigClean
 *
 * @link       http://pyrocms.com/
 * @author     PyroCMS, Inc. <support@pyrocms.com>
 * @author     Ryan Thompson <ryan@pyrocms.com>
 * @deprecated in 1.3 remove in 1.4 - use twig:clear
 */
class TwigClean extends Command
{

    /**
     * The command name.
     *
     * @var string
     */
    protected $name = 'twig:clean';

    /**
     * Handle the command.
     */
    public function handle()
    {
        $this->warn('Deprecated in 1.3 removing in 1.4 - use twig:clear');

        $this->call('twig:clear');
    }
}
