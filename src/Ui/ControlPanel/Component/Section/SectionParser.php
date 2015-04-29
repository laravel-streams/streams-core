<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section;

use Anomaly\Streams\Platform\Support\Parser;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;
use Illuminate\Http\Request;

/**
 * Class SectionParser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section
 */
class SectionParser
{

    /**
     * The parser utility.
     *
     * @var Parser
     */
    protected $parser;

    /**
     * The request object.
     *
     * @var Request
     */
    protected $request;

    /**
     * Create a new SectionParser instance.
     *
     * @param Parser  $parser
     * @param Request $request
     */
    public function __construct(Parser $parser, Request $request)
    {
        $this->parser  = $parser;
        $this->request = $request;
    }

    /**
     * Parse the control panel sections.
     *
     * @param ControlPanelBuilder $builder
     */
    public function parse(ControlPanelBuilder $builder)
    {
        $builder->setSections(
            $this->parser->parse(
                $builder->getSections(),
                [
                    'route_parameters' => $this->getRouteParameters()
                ]
            )
        );
    }

    /**
     * Get the request's route parameters.
     *
     * @return string
     */
    protected function getRouteParameters()
    {
        $route = $this->request->route();

        return implode('/', $route->parameters());
    }
}
