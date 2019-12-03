<?php

namespace Anomaly\Streams\Platform\Ui\ControlPanel\Component\Section;

use Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder;

/**
 * Class SectionInput
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SectionInput
{

    /**
     * Read the section input and process it
     * before building the objects.
     *
     * @param ControlPanelBuilder $builder
     */
    public static function read(ControlPanelBuilder $builder)
    {
        self::resolve($builder);

        SectionNormalizer::normalize($builder);
        SectionGuesser::guess($builder);

        self::evaluate($builder);
        self::parse($builder);
    }

    /**
     * Resolve input.
     *
     * @param \Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder $builder
     */
    protected static function resolve(ControlPanelBuilder $builder)
    {
        $sections = resolver($builder->getSections(), compact('builder'));

        $builder->setSections(evaluate($sections ?: $builder->getSections(), compact('builder')));
    }

    /**
     * Evaluate input.
     *
     * @param \Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder $builder
     */
    protected static function evaluate(ControlPanelBuilder $builder)
    {
        $builder->setSections(evaluate($builder->getSections(), compact('builder')));
    }

    /**
     * Parse input.
     *
     * @param \Anomaly\Streams\Platform\Ui\ControlPanel\ControlPanelBuilder $builder
     */
    protected static function parse(ControlPanelBuilder $builder)
    {
        $builder->setButtons(parse($builder->getButtons()));
    }
}
