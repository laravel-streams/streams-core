<?php namespace Anomaly\Streams\Platform\Ui\Grid\Component\Item;

use Anomaly\Streams\Platform\Support\Hydrator;
use Anomaly\Streams\Platform\Ui\Grid\Component\Item\Contract\ItemInterface;

/**
 * Class ItemFactory
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Ui\Grid
 */
class ItemFactory
{

    /**
     * The hydrator utility.
     *
     * @var Hydrator
     */
    protected $hydrator;

    /**
     * Create a new ItemFactory instance.
     *
     * @param Hydrator $hydrator
     */
    public function __construct(Hydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * Make an item.
     *
     * @param  array $parameters
     * @return ItemInterface
     */
    public function make(array $parameters)
    {
        $item = app()->make('Anomaly\Streams\Platform\Ui\Grid\Component\Item\Item', $parameters);

        $this->hydrator->hydrate($item, $parameters);

        return $item;
    }
}
