<?php namespace Anomaly\Streams\Platform\Ui\Table\View;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Laracasts\Commander\CommanderTrait;

/**
 * Class ViewBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Table\View
 */
class ViewBuilder
{

    use CommanderTrait;

    /**
     * The view converter.
     *
     * @var ViewConverter
     */
    protected $converter;

    /**
     * The view evaluator.
     *
     * @var ViewEvaluator
     */
    protected $evaluator;

    /**
     * The view factory.
     *
     * @var ViewFactory
     */
    protected $factory;

    /**
     * The view loader.
     *
     * @var ViewLoader
     */
    protected $loader;

    /**
     * Create a new ViewBuilder instance.
     *
     * @param ViewConverter $converter
     * @param ViewEvaluator $evaluator
     * @param ViewFactory   $factory
     * @param ViewLoader    $loader
     */
    function __construct(ViewConverter $converter, ViewEvaluator $evaluator, ViewFactory $factory, ViewLoader $loader)
    {
        $this->loader    = $loader;
        $this->factory   = $factory;
        $this->converter = $converter;
        $this->evaluator = $evaluator;
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

            $parameters = $this->converter->standardize($key, $parameters);
            $parameters = $this->evaluator->process($parameters, $builder);

            $view = $this->factory->make($parameters);

            $this->loader->load($view, $parameters);

            $views->put($view->getSlug(), $view);
        }
    }
}
