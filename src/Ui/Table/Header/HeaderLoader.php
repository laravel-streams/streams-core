<?php namespace Anomaly\Streams\Platform\Ui\Table\Header;

use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Ui\Table\Header\Contract\HeaderInterface;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class HeaderLoader
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Header
 */
class HeaderLoader
{

    /**
     * The evaluator utility.
     *
     * @var \Anomaly\Streams\Platform\Support\Evaluator
     */
    protected $evaluator;

    /**
     * Create a new HeaderLoader instance.
     *
     * @param Evaluator $evaluator
     */
    public function __construct(Evaluator $evaluator)
    {
        $this->evaluator = $evaluator;
    }

    /**
     * Load the view data for headers.
     *
     * @param TableBuilder $builder
     */
    public function load(TableBuilder $builder)
    {
        $table = $builder->getTable();
        $data  = $table->getData();

        $headers = array_map(
            function (HeaderInterface $header) {
                return $header->toArray();
            },
            $table->getHeaders()->all()
        );

        $headers = $this->evaluator->evaluate($headers);

        $data->put('headers', $headers);
    }
}
