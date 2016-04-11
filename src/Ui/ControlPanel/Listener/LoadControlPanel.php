<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Listener;

use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Anomaly\Streams\Platform\View\ViewTemplate;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;

/**
 * Class LoadControlPanel
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Listener
 */
class LoadControlPanel
{

    use DispatchesJobs;

    /**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * The view template.
     *
     * @var ViewTemplate
     */
    protected $template;

    /**
     * The control panel builder.
     *
     * @var ControlPanelBuilder
     */
    protected $controlPanel;

    /**
     * Create a new LoadControlPanel instance.
     *
     * @param ControlPanelBuilder $controlPanel
     * @param ViewTemplate        $template
     * @param Request             $request
     */
    public function __construct(ControlPanelBuilder $controlPanel, ViewTemplate $template, Request $request)
    {
        $this->controlPanel = $controlPanel;
        $this->template     = $template;
        $this->request      = $request;
    }

    /**
     * Handle the event.
     */
    public function handle()
    {
        if (in_array($this->request->path(), ['admin/logout'])) {
            return;
        }

        if ($this->request->segment(1) !== 'admin') {
            return;
        }

        $this->template->put('cp', $this->controlPanel->build());
    }
}
