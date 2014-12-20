<?php namespace Anomaly\Streams\Platform\Ui\Table\View;

use Anomaly\Streams\Platform\Support\Evaluator;
use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Anomaly\Streams\Platform\Ui\Table\View\Contract\ViewInterface;

/**
 * Class ViewLoader
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\View
 */
class ViewLoader
{

    /**
     * The evaluator utility.
     *
     * @var \Anomaly\Streams\Platform\Support\Evaluator
     */
    protected $evaluator;

    /**
     * Create a new ViewLoader instance.
     *
     * @param Evaluator $evaluator
     */
    public function __construct(Evaluator $evaluator)
    {
        $this->evaluator = $evaluator;
    }

    /**
     * Load the view data for table views.
     *
     * @param TableBuilder $builder
     */
    public function load(TableBuilder $builder)
    {
        $table = $builder->getTable();
        $data  = $table->getData();

        $views = array_map(
            function (ViewInterface $view) {
                return $view->getTableData();
            },
            $table->getViews()->all()
        );

        $views = $this->evaluator->evaluate($views);

        $data->put('views', $views);
    }
}
