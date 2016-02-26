<?php namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu;

use Anomaly\Streams\Platform\Support\Parser;
use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class MenuParser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\ControlPanel\Component\Menu
 */
class MenuParser
{

    /**
     * The parser utility.
     *
     * @var Parser
     */
    protected $parser;

    /**
     * Create a new MenuParser instance.
     *
     * @param Parser $parser
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Parse the control panel menus.
     *
     * @param ControlPanelBuilder $builder
     */
    public function parse(ControlPanelBuilder $builder)
    {
        $builder->setMenu($this->parser->parse($builder->getMenu()));
    }
}
