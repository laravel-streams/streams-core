<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section;

use Anomaly\Streams\Platform\Support\Authorizer;
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
     * The authorizer utility.
     *
     * @var Authorizer
     */
    protected $authorizer;

    /**
     * Create a new SectionBuilder instance.
     *
     * @param SectionInput   $input
     * @param SectionFactory $factory
     * @param Authorizer     $authorizer
     */
    function __construct(SectionInput $input, SectionFactory $factory, Authorizer $authorizer)
    {
        $this->input      = $input;
        $this->factory    = $factory;
        $this->authorizer = $authorizer;
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

        foreach ($builder->getSections() as $slug => $section) {

            if (!$this->authorizer->authorize($section['permission'])) {
                continue;
            }

            $sections->push($this->factory->make($section));
        }
    }
}
