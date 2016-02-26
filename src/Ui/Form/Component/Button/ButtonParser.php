<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Button;

use Anomaly\Streams\Platform\Support\Parser;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class ButtonParser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Button
 */
class ButtonParser
{

    /**
     * The parser utility.
     *
     * @var Parser
     */
    protected $parser;

    /**
     * Create a new ButtonParser instance.
     *
     * @param Parser $parser
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Parse the form buttons.
     *
     * @param FormBuilder $builder
     */
    public function parse(FormBuilder $builder)
    {
        $entry = $builder->getFormEntry();

        $builder->setButtons($this->parser->parse($builder->getButtons(), compact('entry')));
    }
}
