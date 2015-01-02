<?php namespace Anomaly\Streams\Platform\Ui\Table\Component\View;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;
use Laracasts\Commander\CommanderTrait;

/**
 * Class ViewBuilder
 *
 * @link    http://anomaly.is/streams-platform
 * @author  AnomalyLabs, Inc. <hello@anomaly.is>
 * @author  Ryan Thompson <ryan@anomaly.is>
 * @package Anomaly\Streams\Platform\Ui\Table\Component\View
 */
class ViewBuilder
{

    use CommanderTrait;

    /**
     * The view reader.
     *
     * @var ViewInput
     */
    protected $input;

    /**
     * The view factory.
     *
     * @var ViewFactory
     */
    protected $factory;

    /**
     * Create a new ViewBuilder instance.
     *
     * @param ViewInput   $input
     * @param ViewFactory $factory
     */
    public function __construct(ViewInput $input, ViewFactory $factory)
    {
        $this->input   = $input;
        $this->factory = $factory;
    }

    /**
     * Build the views.
     *
     * @param TableBuilder $builder
     */
    public function build(TableBuilder $builder)
    {
        $table = $builder->getTable();
        $views = $table->getViews();

        $this->input->read($builder);

        foreach ($builder->getViews() as $slug => $view) {
            $views->put($slug, $this->factory->make($view));
        }
    }
}
