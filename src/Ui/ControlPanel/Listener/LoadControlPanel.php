<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Listener;

use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Anomaly\Streams\Platform\View\ViewTemplate;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;

/**
 * Class LoadControlPanel.
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
     * @param Request             $request
     * @param ViewTemplate        $template
     * @param ControlPanelBuilder $controlPanel
     */
    public function __construct(Request $request, ViewTemplate $template, ControlPanelBuilder $controlPanel)
    {
        $this->request      = $request;
        $this->template     = $template;
        $this->controlPanel = $controlPanel;
    }

    /**
     * Handle the event.
     */
    public function handle()
    {
        if (in_array($this->request->path(), ['admin/login', 'admin/logout'])) {
            return;
        }

        if ($this->request->segment(1) !== 'admin') {
            return;
        }

        $this->template->put('cp', $this->controlPanel->build());
    }
}
