<?php namespace Anomaly\Streams\Platform\Ui\Table\Header;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Laracasts\Commander\CommanderTrait;

/**
 * Class HeaderLoader
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\Header
 */
class HeaderLoader
{

    use CommanderTrait;

    /**
     * The header reader.
     *
     * @var HeaderReader
     */
    protected $reader;

    /**
     * The header factory.
     *
     * @var HeaderFactory
     */
    protected $factory;

    /**
     * Create a new HeaderLoader instance.
     *
     * @param HeaderReader  $reader
     * @param HeaderFactory $factory
     */
    function __construct(HeaderReader $reader, HeaderFactory $factory)
    {
        $this->reader  = $reader;
        $this->factory = $factory;
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

            $parameters = $this->reader->standardize($parameters);

            $parameters['stream'] = $table->getStream();

            $header = $this->factory->make($parameters);

            $headers->push($header);
        }
    }
}
