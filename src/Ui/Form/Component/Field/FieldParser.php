<?php namespace Anomaly\Streams\Platform\Ui\Form\Component\Field;

use Anomaly\Streams\Platform\Support\Parser;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Class FieldParser
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Form\Component\Field
 */
class FieldParser
{

    /**
     * The parser instance.
     *
     * @var Parser
     */
    protected $parser;

    /**
     * Create a new FieldParser instance.
     *
     * @param Parser $parser
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Parse the form fields.
     *
     * @param FormBuilder $builder
     */
    public function parse(FormBuilder $builder)
    {
        $entry = $builder->getFormEntry();

        $builder->setFields($this->parser->parse($builder->getFields(), compact('entry')));
    }
}
