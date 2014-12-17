<?php namespace Anomaly\Streams\Platform\Ui\Table\Header;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Laracasts\Commander\CommanderTrait;

/**
 * Class HeaderBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Header
 */
class HeaderBuilder
{

    use CommanderTrait;

    /**
     * The header converter.
     *
     * @var HeaderConverter
     */
    protected $converter;

    /**
     * The header evaluator.
     *
     * @var HeaderEvaluator
     */
    protected $evaluator;

    /**
     * The header factory.
     *
     * @var HeaderFactory
     */
    protected $factory;

    /**
     * Create a new HeaderBuilder instance.
     *
     * @param HeaderConverter $converter
     * @param HeaderEvaluator $evaluator
     * @param HeaderFactory   $factory
     */
    function __construct(HeaderConverter $converter, HeaderEvaluator $evaluator, HeaderFactory $factory)
    {
        $this->factory   = $factory;
        $this->converter = $converter;
        $this->evaluator = $evaluator;
    }

    /**
     * Load headers onto a collection.
     *
     * @param TableBuilder $builder
     */
    public function load(TableBuilder $builder)
    {
        $table   = $builder->getTable();
        $headers = $table->getHeaders();

        foreach ($builder->getColumns() as $parameters) {

            $parameters = $this->converter->standardize($parameters);

            $parameters['stream'] = $table->getStream();

            $header = $this->factory->make($parameters);

            $headers->push($header);
        }
    }
}
