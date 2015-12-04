<?php namespace Anomaly\Streams\Platform\Ui;

use Anomaly\Streams\Platform\Support\Hydrator;
use Anomaly\Streams\Platform\Ui\Icon\IconRegistry;
use Illuminate\Contracts\View\Factory;

/**
 * Class UiPluginFunctions
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui
 */
class UiPluginFunctions
{

    /**
     * The view factory.
     *
     * @var Factory
     */
    protected $view;

    /**
     * The icon registry.
     *
     * @var IconRegistry
     */
    protected $icons;

    /**
     * The hydrator utility.
     *
     * @var Hydrator
     */
    protected $hydrator;

    /**
     * Create a new UiPluginFunctions instance.
     *
     * @param Factory      $view
     * @param IconRegistry $icons
     * @param Hydrator     $hydrator
     */
    public function __construct(Factory $view, IconRegistry $icons, Hydrator $hydrator)
    {
        $this->view     = $view;
        $this->icons    = $icons;
        $this->hydrator = $hydrator;
    }

    /**
     * Return icon HTML.
     *
     * @param      $type
     * @param null $class
     * @return string
     */
    public function icon($type, $class = null)
    {
        return '<i class="' . $this->icons->get($type) . ' ' . $class . '"></i>';
    }

    /**
     * Return icon class.
     *
     * @param      $type
     * @return string
     */
    public function iconClass($type)
    {
        return $this->icons->get($type);
    }

    /**
     * Return a rendered view.
     *
     * @param       $path
     * @param array $data
     * @return string
     */
    public function view($path, array $data = [])
    {
        return $this->view->make($path, $data)->render();
    }

    /**
     * Return the layout if it exists.
     *
     * @param        $layout
     * @param string $default
     * @return string
     */
    public function layout($layout, $default = 'default')
    {
        if ($this->view->exists($layout = "theme::layouts/{$layout}")) {
            return $layout;
        }

        return "theme::layouts/{$default}";
    }

    /**
     * Render buttons.
     *
     * @param $buttons
     * @return \Illuminate\View\View
     */
    public function buttons($buttons)
    {
        return view('streams::buttons/buttons', compact('buttons'));
    }

    /**
     * Render JavaScript constants.
     *
     * @return \Illuminate\View\View
     */
    public function constants()
    {
        return view('streams::partials/constants');
    }

    /**
     * Return elapsed time.
     *
     * @return float
     */
    public function elapsed()
    {
        return number_format(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 2) . ' s';
    }

    /**
     * Get the memory footprint.
     *
     * @return string
     */
    public function footprint()
    {
        $size = memory_get_usage(true);

        $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');

        return round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }
}
