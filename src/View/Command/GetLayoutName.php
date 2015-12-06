<?php namespace Anomaly\Streams\Platform\View\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\View\Factory;

/**
 * Class GetLayoutName
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\View\Command
 */
class GetLayoutName implements SelfHandling
{

    /**
     * The layout name.
     *
     * @var string
     */
    protected $layout;

    /**
     * The default layout name.
     *
     * @var string
     */
    protected $default;

    /**
     * Create a new GetLayoutName instance.
     *
     * @param string $default
     * @param string $layout
     */
    public function __construct($layout, $default = 'default')
    {
        $this->layout  = $layout;
        $this->default = $default;
    }

    /**
     * Handle the command.
     *
     * @param Factory $view
     * @return string
     */
    public function handle(Factory $view)
    {
        if ($view->exists($layout = "theme::layouts/{$this->layout}")) {
            return $layout;
        }

        return "theme::layouts/{$this->default}";
    }
}
