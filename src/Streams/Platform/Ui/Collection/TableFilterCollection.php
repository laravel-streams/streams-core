<?php namespace Streams\Platform\Ui\Collection;

use Streams\Platform\Ui\TableUi;
use Streams\Platform\Support\Collection;
use Streams\Platform\Ui\Support\TableFilter;
use Streams\Platform\Ui\Contract\TableFilterInterface;
use Streams\Platform\Ui\Contract\TableViewInterface;

class TableFilterCollection extends Collection
{
    /**
     * Create a new TableFilterCollection instance.
     *
     * @param TableUi $ui
     * @param array   $items
     */
    public function __construct(TableUi $ui, $items = [])
    {
        foreach ($items as &$item) {
            if (!$item instanceof TableFilterInterface) {
                $item = new TableFilter($ui, $item);
            }
        }

        parent::__construct($items);
    }
}