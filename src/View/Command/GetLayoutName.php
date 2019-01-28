<?php namespace Anomaly\Streams\Platform\View\Command;

/**
 * Class GetLayoutName
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GetLayoutName
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
     * @return string
     */
    public function handle()
    {
        if (str_contains($this->layout, '::')) {
            return $this->layout;
        }

        if (!str_contains($this->layout, '::')) {
            return "theme::layouts/{$this->layout}";
        }

        return str_contains($this->default, '::') ? $this->default : "theme::layouts/{$this->default}";
    }
}
