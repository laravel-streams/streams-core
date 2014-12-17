<?php namespace Anomaly\Streams\Platform\Ui\Table\View;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Laracasts\Commander\CommanderTrait;

/**
 * Class ViewLoader
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\View
 */
class ViewLoader
{

    use CommanderTrait;

    /**
     * The view reader.
     *
     * @var ViewReader
     */
    protected $reader;

    /**
     * The view factory.
     *
     * @var ViewFactory
     */
    protected $factory;

    /**
     * Create a new ViewLoader instance.
     *
     * @param ViewReader  $reader
     * @param ViewFactory $factory
     */
    function __construct(ViewReader $reader, ViewFactory $factory)
    {
        $this->reader  = $reader;
        $this->factory = $factory;
    }

    /**
     * Load views onto a collection.
     *
     * @param TableBuilder $builder
     */
    public function load(TableBuilder $builder)
    {
        $table = $builder->getTable();
        $views = $table->getViews();

        foreach ($builder->getViews() as $key => $parameters) {

            $parameters = $this->reader->standardize($key, $parameters);

            $view = $this->factory->make($parameters);

            $views->put($view->getSlug(), $view);
        }
    }
}
