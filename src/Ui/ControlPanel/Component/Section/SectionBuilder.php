<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section;

use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class SectionBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section
 */
class SectionBuilder
{

    /**
     * The section input.
     *
     * @var SectionInput
     */
    protected $input;

    /**
     * The section factory.
     *
     * @var SectionFactory
     */
    protected $factory;

    /**
     * Create a new SectionBuilder instance.
     *
     * @param SectionInput   $input
     * @param SectionFactory $factory
     */
    function __construct(SectionInput $input, SectionFactory $factory)
    {
        $this->input   = $input;
        $this->factory = $factory;
    }

    /**
     * Build the sections and push them to the control_panel.
     *
     * @param ControlPanelBuilder $builder
     */
    public function build(ControlPanelBuilder $builder)
    {
        $controlPanel = $builder->getControlPanel();
        $sections     = $controlPanel->getSections();

        $this->input->read($builder);

        foreach ($builder->getSections() as $slug => $view) {
            $sections->push($this->factory->make($view));
        }
    }
}
